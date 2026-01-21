<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Files;
use Illuminate\Support\Facades\Storage;
use Yaza\LaravelGoogleDriveStorage\Gdrive;

class FileController extends Controller
{
    public function view($token)
    {
        $file = Files::where('file_token', $token)->firstOrFail();

        $stream = Gdrive::readStream($file->google_file_path);

        abort_if(!$stream || !$stream->file, 404);

        return response()->stream(function () use ($stream) {
            fpassthru($stream->file);
        }, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $file->original_name . '"',
            'Cache-Control'      => 'no-store, no-cache, must-revalidate',
            'Pragma'             => 'no-cache',
        ]);
    }
}
