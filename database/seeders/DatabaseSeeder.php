<?php

namespace Database\Seeders;

use App\Models\Config;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // 建立預設管理員帳號
        $user = User::create([
            'name' => env('DEFAULT_ADMIN_NAME', '管理員'),
            'email' => env('DEFAULT_ADMIN_EMAIL', 'admin@local.test'),
            'username' => env('DEFAULT_ADMIN_USERNAME', 'admin'),
            'password' => bcrypt(env('DEFAULT_ADMIN_PASSWORD', '12345678')),
            'is_admin' => 1,
        ]);

        Config::create(['name' => 'public_view', 'enable' => false]); // 開放觀摩
        Config::create(['name' => 'eg_upload', 'enable' => false]); // 國小遊戲組可上傳
        Config::create(['name' => 'ea_upload', 'enable' => false]); // 國小動畫組可上傳
        Config::create(['name' => 'jg_upload', 'enable' => false]); // 國中遊戲組可上傳
        Config::create(['name' => 'ja_upload', 'enable' => false]); // 國中動畫組可上傳
    }
}
