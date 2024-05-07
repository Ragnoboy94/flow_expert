<?php

namespace App\Jobs;

use App\Models\DemandFile;
use App\Services\GrantService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendFileToGrantAPI implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;
    protected $demandFile;
    public function __construct($filePath, DemandFile $demandFile)
    {
        $this->filePath = $filePath;
        $this->demandFile = $demandFile;
    }

    public function handle(GrantService $grantService)
    {
        $grantResponse = $grantService->uploadFile($this->filePath);
        $this->demandFile->update([
            'file_work_id' => $grantResponse['FileWorkId'] ?? null
        ]);
    }
}
