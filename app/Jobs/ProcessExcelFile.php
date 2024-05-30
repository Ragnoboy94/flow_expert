<?php

namespace App\Jobs;

use App\Imports\ExcelRowsImport;
use App\Models\DemandFile;
use App\Models\ExcelRow;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ProcessExcelFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $demandFile;

    /**
     * Create a new job instance.
     */
    public function __construct(DemandFile $demandFile)
    {
        $this->demandFile = $demandFile;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $filePath = public_path('processed_files/' . $this->demandFile->new_filename);
        ExcelRow::where('demand_file_id', $this->demandFile->id)->delete();
        Excel::import(new ExcelRowsImport($this->demandFile->id), $filePath);
        $this->demandFile->update([
            'status_id' => 3,
            'split_into_lots' => true
        ]);
        CheckItemNameInXmlData::dispatch($this->demandFile->id);
    }
}
