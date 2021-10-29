<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Http\Request;

class SystemConfigController extends Controller
{
    public function __invoke(Request $request)
    {
        $config_name = $request->name;

        $config = Config::whereName($config_name)->firstOrFail();
        $config->enable = !$config->enable;
        $config->save();

        return back()->with('msg', '設定調整完成');
    }
}
