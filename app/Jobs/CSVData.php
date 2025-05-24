<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Bus\Batchable;
use App\Models\Customer;

class CSVData implements ShouldQueue
{
    use Queueable,
        Batchable;
        public $header;
        public $data;

    /**
     * Create a new job instance.
     */
    public function __construct($data,$header)
    {
        $this->header = $header;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->data as $row) {
            $customerData = [];
            foreach ($this->header as $index => $column) {
                $customerData[$column] = $row[$index];
            }
            Customer::create($customerData);
        }
    }
}
