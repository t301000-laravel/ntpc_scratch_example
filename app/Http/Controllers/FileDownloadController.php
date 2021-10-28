<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileDownloadController extends Controller
{
    public function __invoke(File $file)
    {
        abort_if($file->user_id !== auth()->id(), 404);

        return Storage::download($file->path);
    }
}
