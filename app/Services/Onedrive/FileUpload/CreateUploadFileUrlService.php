<?php

namespace App\Services\Onedrive\FileUpload;

class CreateUploadFileUrlService {
    public function create(string $uploadFolderPath,?string $parentFolderId = null) : string{
        if(!empty($parentFolderId)){
            return "https://graph.microsoft.com/v1.0/me/drive/items/$parentFolderId:/$uploadFolderPath:/content";
        }
        return 'https://graph.microsoft.com/v1.0/drive/root:/'. $uploadFolderPath. ':/content';
    }
}
