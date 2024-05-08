<?php

namespace App\Jobs;

use App\Models\DemandFile;
use App\Services\GrantService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckAndDownloadProcessedFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $demandFile;

    public function __construct(DemandFile $demandFile)
    {
        $this->demandFile = $demandFile;
    }

    public function handle(GrantService $grantService)
    {
        $statusInfo = $grantService->getFileStatus();

        if (!empty($statusInfo['Files'])) {
            foreach ($statusInfo['Files'] as $file) {
                if ($file['FileWorkId'] === $this->demandFile->file_work_id) {
                    if ($file['StatusId'] === 3) {
                        $processedFileContent = $grantService->fetchProcessedFile($this->demandFile->file_work_id);
                        $pathToSave = public_path('processed_files/' . $this->demandFile->filename);
                        file_put_contents($pathToSave, $processedFileContent);
                        $this->demandFile->update([
                            'status_id' => 3,
                            'count_row' => $file['CountRow'],
                            'count_accept' => $file['CountAccept'],
                            'count_failed' => $file['CountFailed'],
                            'new_filename' => $this->demandFile->filename
                        ]);
                    } elseif (!is_null($file['ErrorDescription'])) {
                        $this->demandFile->update([
                            'status_id' => 4,
                            'error_description' => $file['ErrorDescription']
                        ]);
                    }
                    break;
                }
            }
        }
    }
}
