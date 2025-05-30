<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class CSVValidator
{
    protected $errors = [];
    protected $validRows = [];
    protected $invalidRows = [];
    protected $headers = [];

    public function validate(array $headers, array $data): array
    {
        $this->headers = $headers;
        $this->errors = [];
        $this->validRows = [];
        $this->invalidRows = [];

        // Validate headers
        if (!$this->validateHeaders()) {
            return [
                'isValid' => false,
                'errors' => $this->errors,
                'validRows' => [],
                'invalidRows' => [],
                'totalRows' => count($data)
            ];
        }

        // Validate each row
        foreach ($data as $index => $row) {
            $rowNumber = $index + 2; // +2 because index starts at 0 and we skip header row
            $rowData = array_combine($headers, $row);
            
            $validator = Validator::make($rowData, [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                // Add more validation rules based on your CSV structure
            ]);

            if ($validator->fails()) {
                $this->invalidRows[] = [
                    'row' => $rowNumber,
                    'data' => $rowData,
                    'errors' => $validator->errors()->toArray()
                ];
            } else {
                $this->validRows[] = $rowData;
            }
        }

        return [
            'isValid' => count($this->invalidRows) === 0,
            'errors' => $this->errors,
            'validRows' => $this->validRows,
            'invalidRows' => $this->invalidRows,
            'totalRows' => count($data),
            'validCount' => count($this->validRows),
            'invalidCount' => count($this->invalidRows)
        ];
    }

    protected function validateHeaders(): bool
    {
        $requiredHeaders = ['name', 'email', 'phone']; // Add your required headers here
        
        $missingHeaders = array_diff($requiredHeaders, $this->headers);
        
        if (!empty($missingHeaders)) {
            $this->errors[] = "Missing required headers: " . implode(', ', $missingHeaders);
            return false;
        }

        return true;
    }
} 