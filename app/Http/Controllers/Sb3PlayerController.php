<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Sb3PlayerController extends Controller
{
    public function __invoke(File $file)
    {
        abort_if(Storage::missing($file->path), 404);

        list($folder, $fileInfo['group'], $fileInfo['filename']) = explode('/', $file->path);
        $fileInfo['base64'] = base64_encode(Storage::get($file->path));

        return view('sb3_player', ['fileInfo' => $fileInfo]);
    }
}
