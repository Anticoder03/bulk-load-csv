<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Jobs\CSVData;
use Illuminate\Support\Facades\Bus;
use App\Services\CSVValidator;
use Illuminate\Support\Facades\Session;

class Customer extends Controller
{
    protected $csvValidator;

    public function __construct(CSVValidator $csvValidator)
    {
        $this->csvValidator = $csvValidator;
    }

    public function index(): View
    {
        return view('customer');
    }

    public function validate(Request $request)
    {
        $request->validate([
            'csv' => 'required|file|mimes:csv,txt|max:10240' // 10MB max
        ]);

        $file = $request->file('csv');
        $header = null;
        $data = [];

        if (($handle = fopen($file, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                if (!$header) {
                    $header = $row;
                } else {
                    $data[] = $row;
                }
            }
            fclose($handle);
        }

        // Store the CSV data in session for the next stage
        Session::put('csv_data', [
            'header' => $header,
            'data' => $data
        ]);

        // Validate the CSV data
        $validationResult = $this->csvValidator->validate($header, $data);

        return view('customer-validation', [
            'validationResult' => $validationResult,
            'headers' => $header,
            'previewData' => array_slice($data, 0, 5) // Show first 5 rows as preview
        ]);
    }

    public function process(Request $request)
    {
        if (!Session::has('csv_data')) {
            return redirect()->route('customer.index')
                ->with('error', 'No CSV data found. Please upload the file again.');
        }

        $csvData = Session::get('csv_data');
        
        // Validate again before import
        $validationResult = $this->csvValidator->validate($csvData['header'], $csvData['data']);
        
        if (!$validationResult['isValid']) {
            return redirect()->route('customer.index')
                ->with('error', 'CSV validation failed. Please fix the errors and try again.');
        }

        // Dispatch the job to process the CSV data
        Bus::batch([
            new CSVData($validationResult['validRows'], $csvData['header']),
        ])->dispatch();

        // Clear the session data
        Session::forget('csv_data');

        return redirect()->route('customer.index')
            ->with('success', sprintf(
                'CSV file imported successfully! Processed %d records.',
                $validationResult['validCount']
            ));
    }
}
