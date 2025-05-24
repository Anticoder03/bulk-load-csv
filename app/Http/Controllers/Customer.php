<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Jobs\CSVData;
use Illuminate\Support\Facades\Bus;
class Customer extends Controller
{
    public function index(): View
    {
        return view('customer');
    }
    public function import(Request $request)
    {
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

        // Dispatch the job to process the CSV data
        Bus::batch([
            new CSVData($data, $header),
        ])->dispatch();

        return redirect()->back()->with('success', 'CSV file imported successfully!');
    }
    public function store(Request $request)
    {
       if($request->has('csv')) {
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

            // Dispatch the job to process the CSV data
            Bus::batch([
                new CSVData($data, $header),
            ])->dispatch();

            return redirect()->back()->with('success', 'CSV file imported successfully!');
        }

        
    }
}
