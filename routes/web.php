<?php

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
    return redirect()->route('dashboard');
});

Auth::routes();

// ADMIN PANEL ROUTES---------------------------------------
Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function() {
    // DASHBOARD
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    // BLADE INDEXES----------------------------------------------------------------
    Route::get('/dashboard', 'Admin\DashboardController@index')->name('dashboard');
    Route::get('/index_realtors', 'Admin\UserController@index_realtors')->name('index_realtors');
    Route::get('/index_cleaners', 'Admin\UserController@index_cleaners')->name('index_cleaners');
    // ----------------------------------------------------------------------------

    // API RESOURCES-------------------------------------------------
    Route::apiResources(['user'=>'Admin\UserController']);
    Route::apiResources(['lead'=>'Admin\LeadController']);
    Route::apiResources(['keyword'=>'Admin\KeywordController']);
    Route::apiResources(['keywordtype'=>'Admin\KeywordTypeController']);
    Route::apiResources(['logo'=>'Admin\LogoController']);
    Route::apiResources(['video'=>'Admin\VideoController']);
    // --------------------------------------------------------------

    // SEARCH ROUTES--------------------------------------------------------------------------------------------
    Route::get('/search_users', 'Admin\UserController@search_users')->name('search_users');
    Route::get('/search_leads', 'Admin\LeadController@search_leads')->name('search_leads');
    Route::get('/search_keyword', 'Admin\KeywordController@search_keywords')->name('search_keyword');
    Route::get('/search_keyword_types', 'Admin\KeywordTypeController@search_keywordtypes')->name('search_keyword_types');
    Route::get('/search_logos', 'Admin\LogoController@search_logos')->name('search_logos');
    Route::get('/search_videos', 'Admin\LogoController@search_videos')->name('search_videos');
    // ---------------------------------------------------------------------------------------------------------

    // HELPERS---------------------------------------------------------------------------------------------------------------
    Route::get('/toggle_logo_status', 'Admin\LogoController@toggle_logo_status')->name('toggle_logo_status');
    Route::get('/toggle_video_status', 'Admin\VideoController@toggle_video_status')->name('toggle_video_status');
    // ----------------------------------------------------------------------------------------------------------------------
});

// ARTISAN COMMAND ROUTES---------------------------------------
// Route::get('/install', function () {
//     // Illuminate\Support\Facades\Artisan::call('migrate:fresh', [
//     //     '--seed' => true
//     // ]);
// });
// Route::get('/migrate', function () {
//     Illuminate\Support\Facades\Artisan::call('migrate');
// });
// Route::get('/stepmigrate', function () {
//     Illuminate\Support\Facades\Artisan::call('migrate:rollback', [
//         '--step' => 1
//     ]);
// });
Route::get('/clear', function () {
    Illuminate\Support\Facades\Artisan::call('cache:clear');
    Illuminate\Support\Facades\Artisan::call('config:clear');
    Illuminate\Support\Facades\Artisan::call('config:cache');
    Illuminate\Support\Facades\Artisan::call('view:clear');
});
// Route::get('/passport', function () {
//     Illuminate\Support\Facades\Artisan::call('passport:install');
// });
// Route::get('/key', function () {
//     Illuminate\Support\Facades\Artisan::call('key:generate');
// });
// Route::get('/storage', function () {
//     Illuminate\Support\Facades\Artisan::call('storage:link');
// });
// Route::get('/composer-du', function()
// {
//     Illuminate\Support\Facades\Artisan::call('dump-autoload');
// });
//--------------------------------------------------------------

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// check_for_ip
Route::get('/check_for_ip', 'HomeController@check_for_ip')->name('check_for_ip');
// ip_auth
Route::get('/ip_auth', 'HomeController@ip_auth')->name('ip_auth');