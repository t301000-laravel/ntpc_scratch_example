<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user()->load(['team', 'files']);

        if ($user->team) {
            $can_upload = $this->canUpload($user->team->game_group);

            // 不允許上傳時則強制登出
            if (!$can_upload) {
                Auth::logout();
                $request->session()->invalidate();

                return redirect('/');
            }
        }

        return view('upload', [
            'user' => $user
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
            'msg' => now() . " 檔案上傳成功。 " . Str::replaceFirst('sb3/', '', $path)
        ];

        return back()->with('status', $msg);
    }

    private function canUpload($game_group)
    {
        switch ($game_group) {
            case '國小遊戲組':
                $config_name = 'eg_upload';
                break;
            case '國小動畫組':
                $config_name = 'ea_upload';
                break;
            case '國中遊戲組':
                $config_name = 'jg_upload';
                break;
            case '國中動畫組':
                $config_name = 'ja_upload';
                break;
        }

        return Config::whereName($config_name)->first()->enable;
    }
}
