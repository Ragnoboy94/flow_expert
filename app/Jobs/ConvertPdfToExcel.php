<?php

namespace App\Jobs;

use App\Models\Offer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class ConvertPdfToExcel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $offer;
    protected $apikey;

    /**
     * Create a new job instance.
     */
    public function __construct(Offer $offer)
    {
        $this->offer = $offer;
        $this->apikey = config('services.pdftables.api_key');
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $pdfFile = public_path('offers/' . $this->offer->file_path);

        if (!is_readable($pdfFile)) {
            $this->offer->update(['file_status_id' => 4]);
            throw new \Exception("Error: file does not exist or is not readable: $pdfFile");
        }
        $this->offer->update(['file_status_id' => 2]);

        $response = Http::attach('file', file_get_contents($pdfFile), 'file.pdf')
            ->post("https://pdftables.com/api?key={$this->apikey}&format=xlsx-single");

        if ($response->failed()) {
            $this->offer->update(['file_status_id' => 4]);
            throw new \Exception('Error calling PDFTables: ' . $response->body());
        } else {
            $excelFilePath = str_replace('.pdf', '.xlsx', $this->offer->file_path);
            $pathToSave = public_path('offers/' . $excelFilePath);
            file_put_contents($pathToSave, $response->body());
            $this->offer->update([
                'file_status_id' => 3,
                'excel_file_path' => $excelFilePath
            ]);
        }
    }
}
