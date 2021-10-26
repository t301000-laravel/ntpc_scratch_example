<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadController extends Controller
{
    public function index()
    {
        return view('upload', [
            'user' => auth()->user()->load(['team', 'files'])
        ]);
    }

    public function upload(Request $request)
    {
        $max_MB = env('MAX_FILE_SIZE_MB', 1);

        $rules = [
            'myfile' => [
                'file',
                'max:' . $max_MB * 1024, // KB
                // 檢查副檔名
                function ($attribute, $value, $fail) {
                    if (Str::lower($value->getClientOriginalExtension()) !== 'sb3') {
                        $fail('只能上傳 sb3 檔。');
                    }
                },
            ]
        ];

        $error_messages = [
            'max' => "檔案太大，最大 {$max_MB} MB。"
        ];

        $request->validate($rules, $error_messages);

        $currentUser = auth()->user()->load('team');

        $filename = "{$currentUser->username}_{$currentUser->team->school_name}.sb3";
        $game_group = $currentUser->team->game_group;

        $count = 0;
        while (Storage::exists(("sb3/{$game_group}/{$filename}"))) {
            $count++;
            $filename = "{$currentUser->username}_{$currentUser->team->school_name}_{$count}.sb3";
        }
        $path = $request->file('myfile')->storeAs('sb3/' . $game_group, $filename);

        File::create([
            'user_id' => $currentUser->id,
            'path' => $path
        ]);

        $msg = [
            'type' => 'success',
            'msg' => now() . " 檔案上傳成功。 {$path}"
        ];

        return back()->with('status', $msg);
    }
}
