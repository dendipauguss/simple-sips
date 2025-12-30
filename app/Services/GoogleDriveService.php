<?php

namespace App\Services;

use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;
use Google\Service\Drive\Permission;
use Illuminate\Http\UploadedFile;

class GoogleDriveService
{
    protected Drive $drive;
    protected string $folderId;

    public function __construct()
    {
        $client = new Client();
        $client->setAuthConfig(base_path('siomes-bappebti-storage.json'));
        $client->addScope(Drive::DRIVE);

        $this->drive = new Drive($client);
        $this->folderId = config('services.google.drive_folder_id');
    }

    public function upload(UploadedFile $file): array
    {
        $filename = time() . '_' . $file->getClientOriginalName();

        $fileMetadata = new DriveFile([
            'name' => $filename,
            'parents' => [$this->folderId],
        ]);

        $uploaded = $this->drive->files->create(
            $fileMetadata,
            [
                'data' => file_get_contents($file->getRealPath()),
                'mimeType' => $file->getMimeType(),
                'uploadType' => 'multipart',
                'supportsAllDrives' => true,
                // 'fields' => 'id, name, mimeType, webViewLink',
            ]
        );

        // Public read (optional)
        $this->drive->permissions->create(
            $uploaded->id,
            new Permission([
                'type' => 'anyone',
                'role' => 'reader',
            ]),
            ['supportsAllDrives' => true]
        );

        return [
            'file_id' => $uploaded->id,
            'name' => $uploaded->name,
            'mime' => $uploaded->mimeType,
            'url'  => $uploaded->webViewLink,
        ];
    }

    public function delete(string $fileId): void
    {
        $this->drive->files->delete($fileId, [
            'supportsAllDrives' => true
        ]);
    }
}
