<?php

namespace App\Jobs;

use App\Imports\MedicinesRowsImport;
use App\Models\Offer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ImportExcelData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $offer;
    /**
     * Create a new job instance.
     */
    public function __construct(Offer $offer)
    {
        $this->offer = $offer;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $filePath = public_path('offers/' . $this->offer->excel_file_path);
        Excel::import(new MedicinesRowsImport($this->offer->id), $filePath);
        $this->offer->update([
            'file_status_id' => 3
        ]);
    }
}
