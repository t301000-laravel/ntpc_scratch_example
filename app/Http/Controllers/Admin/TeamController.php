<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\TeamsImport;
use App\Models\File;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class TeamController extends Controller
{
    public function index()
    {
        $group = request('group', '國小遊戲組');
        // $users = User::whereIsAdmin(false)->paginate(2);
        // $users = User::whereIsAdmin(false)
        //     ->with(['team' => function($query) use ($group) {
        //         $query->where('game_group', $group);
        //     }])
        //     ->get();
        $teams = Team::with('user')->whereGameGroup($group)->get();

        return view('admin.teams.index', ['teams' => $teams, 'group' => $group]);
    }

    public function create()
    {
        $group = request('group');
        return view('admin.teams.create', ['group' => $group]);
    }

    public function store(Request $request)
    {
        $rules = [
            'username' => ['required', 'unique:users'],
            'password' => ['required'],
            'school_name' => ['required'],
            'game_group' => ['required'],
        ];

        $error_messages = [
            'username.required' => "帳號未填。",
            'username.unique' => "帳號重複。",
            'password.required' => "密碼未填。",
            'school_name.required' => "學校未填。",
            'game_group.required' => "缺少參賽組別。",
        ];

        $data = $request->validate($rules, $error_messages);

        $user = User::create([
            'name' => $data['school_name'],
            'email' => $data['username'] . "@test.tw",
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
        ]);

        $user->team()->create([
            'school_name' => $data['school_name'],
            'game_group' => $data['game_group'],
        ]);

        return redirect()->route('admin.teams.index', ['group' => $data['game_group']])
            ->with('msg', "名單新增完成： {$data['game_group']} {$data['username']} {$data['school_name']}");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function edit(Team $team)
    {
        return view('admin.teams.edit', ['team' => $team]);
    }

    public function update(Request $request, Team $team)
    {
        $data = $request->validate(['password' => 'required']);

        $team->user->password = bcrypt($data['password']);
        $team->user->save();

        // session()->flash('msg', $team->school_name . " 密碼已變更。");

        return redirect()->route('admin.teams.index', ['group' => $team->game_group])
            ->with('msg', $team->school_name . " 密碼已變更。");
    }

    public function destroy(Team $team)
    {
        $user = $team->user;
        foreach ($user->files as $file) {
            Storage::delete($file->path);
        }
        $user->files()->delete();
        $team->delete();
        $user->delete();

        return back()->with('msg', "{$team->school_name} 資料與檔案已刪除。");
    }

    public function import(Request $request)
    {
        $request->validate([
            'list' => ['file']
        ]);

        $file = $request->file('list');

        Schema::disableForeignKeyConstraints(); // 關閉外鍵檢查
        File::truncate();
        Team::truncate();
        User::where('id', '!=', auth()->id())->delete();
        Schema::enableForeignKeyConstraints(); // 開啟外鍵檢查

        Storage::deleteDirectory("sb3"); // 刪除 storage/app/sb3 資料夾

        HeadingRowFormatter::default('none');
        $import = new TeamsImport;
        Excel::import($import, $file);

        return redirect()->route('admin.teams.index')
            ->with('msg', "匯入名單完成，共 {$import->getRowCount()} 筆資料。");
    }
}
