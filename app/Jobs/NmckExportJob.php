<?php

namespace App\Jobs;

use App\Exports\NmckExport;
use App\Models\NmckFile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class NmckExportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $fileId;
    protected $offerIds;
    protected $openSource;
    protected $filePath;
    protected $nmck;

    public function __construct($fileId, $offerIds, $openSource, $filePath, NmckFile $nmck)
    {
        $this->fileId = $fileId;
        $this->offerIds = $offerIds;
        $this->openSource = $openSource;
        $this->filePath = $filePath;
        $this->nmck = $nmck;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $this->nmck->update(['status_id' => 2]);
            Excel::store(new NmckExport($this->fileId, $this->offerIds, $this->openSource), $this->filePath, 'public');
            $this->nmck->update(['status_id' => 3]);
        } catch (\Exception $e) {
            $this->nmck->update(['status_id' => 4]);
            Log::error('Ошибка при выполнении NmckExportJob: ' . $e->getMessage(), [
                'fileId' => $this->fileId,
                'offerIds' => $this->offerIds,
                'openSource' => $this->openSource,
                'filePath' => $this->filePath,
                'exception' => $e,
            ]);
        }
    }
}
