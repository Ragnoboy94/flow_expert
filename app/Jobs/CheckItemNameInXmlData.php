<?php

namespace App\Jobs;

use App\Models\ExcelRow;
use App\Models\XmlData;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckItemNameInXmlData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $demandFileId;

    /**
     * Create a new job instance.
     */
    public function __construct($demandFileId)
    {
        $this->demandFileId = $demandFileId;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $excelRows = ExcelRow::where('demand_file_id', $this->demandFileId)->get();

        foreach ($excelRows as $excelRow) {
            $itemName = $excelRow->item_name;

            $itemNameParts = explode(',', mb_strtolower($itemName));
            $itemNameShort = $itemNameParts[0];
            $match = XmlData::where('search_name', $itemNameShort)->first();

            if ($match) {
                $excelRow->update(['xml_data_id' => $match->id]);
            }
        }
    }
}
