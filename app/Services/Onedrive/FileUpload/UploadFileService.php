<?php

namespace App\Services\Onedrive\FileUpload;


use App\Services\Onedrive\Auth\AccessTokenService;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UploadFileService
{
    public function __construct(
        private AccessTokenService         $accessTokenService,
        private CreateUploadFileUrlService $createUploadFileUrlService,
    ) {}

    /**
     * @throws ConnectionException
     * @throws Exception
     */
    public function upload(
        UploadedFile $uploadedFile,
        string       $filePathWithNameOnOnedrive,
        ?string $parentFolderId = null,
    ): array|null {
        $token = $this->accessTokenService->getAccessToken();
        $uploadUrl = $this->createUploadFileUrlService->create($filePathWithNameOnOnedrive, $parentFolderId);
        $fileContent = $uploadedFile->getContent();
        $response = Http::withHeaders([
            'Authorization' => "Bearer $token",
        ])
            ->withBody($fileContent, 'text/plain')
            ->put($uploadUrl);
        if (!$response->successful()) {
            Log::critical('File path on onedrive: ' . $filePathWithNameOnOnedrive);
            Log::critical('Upload url: ' . $uploadUrl);
            Log::critical(json_encode($response->body()));
            throw new Exception('Unable to upload file');
        }
        return $response->json();
    }
}
