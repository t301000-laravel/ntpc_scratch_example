<?php

    use App\Http\Controllers\Admin\TeamController;
    use App\Http\Controllers\Auth\AuthController;
    use App\Http\Controllers\FileDownloadController;
    use App\Http\Controllers\FileUploadController;
    use App\Http\Controllers\GalleryItemController;
    use App\Http\Controllers\GameDashboardController;
    use App\Http\Controllers\Sb3PlayerController;
    use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('dashboard/{group}', GameDashboardController::class)->name('dashboard');

Route::group(['middleware' => 'guest'], function () {
    Route::view('login', 'login')->name('login');
    Route::post('login', [AuthController::class, 'login']);

    Route::get('ntpc-login', [AuthController::class, 'loginByNTPCOpenID']);
});

Route::group(['middleware' => 'auth'], function () {

    Route::get('upload', [FileUploadController::class, 'index'])->name('upload');
    Route::post('upload', [FileUploadController::class, 'upload']);

    Route::get('download/{file}', FileDownloadController::class)->name('download');

    Route::get('profile', [AuthController::class, 'profile'])->name('profile');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::group([
    'middleware' => ['auth', 'auth.is_admin'],
    'prefix' => 'admin',
    'as' => 'admin.'
], function () {

    Route::resource('teams', TeamController::class)->except(['show']);
    Route::view('teams/import', 'admin.teams.import')->name('teams.import');
    Route::post('teams/import', [TeamController::class, 'import']);

    Route::view('system', 'admin.system.index')->name('system-config.index');
    Route::get('system/update', \App\Http\Controllers\SystemConfigController::class)->name('system-config.update');
});

Route::get('sb3_player/{file}', Sb3PlayerController::class)->name('player');

require __DIR__ . '/ntpcopenid.php';

Route::resource('gallery', GalleryItemController::class);
