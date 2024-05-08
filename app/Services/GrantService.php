<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class GrantService
{
    protected $token;

    public function authenticate()
    {
        $response = Http::post(config('grant.base_uri') . '/GetToken', [
            'Login' => config('grant.login'),
            'Password' => config('grant.password')
        ]);

        if ($response->successful() && $response['Success']) {
            $this->token = $response['Token'];
            return $this->token;
        } else {
            throw new \Exception('Authentication with Grant API failed');
        }
    }

    public function uploadFile($filePath)
    {
        if (!$this->token) {
            $this->authenticate();
        }

        $fileContents = file_get_contents($filePath);
        $base64File = base64_encode($fileContents);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->post(config('grant.base_uri') . '/Upload', [
            'FileName' => basename($filePath),
            'File' => $base64File
        ]);

        if ($response->successful()) {
            return $response->json();
        } else {
            throw new \Exception('Failed to upload file to Grant API');
        }
    }

    public function fetchProcessedFile($fileWorkId)
    {
        $this->authenticate();

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->post(config('grant.base_uri') . '/DownLoadExport', [
            'FileWorkId' => $fileWorkId
        ]);

        if ($response->successful()) {
            return $response->body();
        } else {
            throw new \Exception('Failed to download processed file from Grant API');
        }
    }

    public function getFileStatus()
    {
        if (!$this->token) {
            $this->authenticate();
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->post(config('grant.base_uri') . '/GetFiles', [
            'Offset' => 0,
            'Limit' => 1000
        ]);
        if ($response->successful()) {
            return $response->json();
        } else {
            throw new \Exception('Failed to check file status from Grant API');
        }
    }

}
