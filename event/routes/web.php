<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pages\Page2;
use App\Http\Controllers\pricelist\PricelistController;

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

$controller_path = 'App\Http\Controllers';

// Main Page Route
Route::get('/marketing', $controller_path . '\pages\HomePage@index')->name('pages-home')->middleware('ensure.user');

Route::get('/finance', $controller_path . '\pages\HomePage@finance')->name('pages-finance')->middleware('ensure.user');

// portal bbm
//Route::get('/', $controller_path . '\pages\HomePage@portalBBM')->name('pages-portal')->middleware('ensure.user');
Route::get('/', $controller_path . '\pages\HomePage@index')->name('pages-portal')->middleware('ensure.user');

Route::get('/home-page-updt', $controller_path . '\pages\HomePage@update')->name('pages-home-updt');
Route::get('/page-2', $controller_path . '\pages\Page2@index')->name('event-new')->middleware('ensure.user');
Route::post('/proses_save_event', $controller_path . '\pages\Page2@save_event_proses')->name('pages-save-event');
Route::get('/list_event', $controller_path . '\pages\Page2@list_event')->name('event-list')->middleware('ensure.user');
Route::get('/get_data_list_event', $controller_path . '\pages\Page2@get_data_list_event')->name('pages-get-data-event');
Route::get('/edit_event_list', $controller_path . '\pages\Page2@edit_event_list')->name('pages-edit-data-event')->middleware('ensure.user');
Route::post('/proses_update_event', $controller_path . '\pages\Page2@update_event_proses')->name('update-save-event');
Route::post('/proses_upload_report', $controller_path . '\pages\Page2@proses_upload_report')->name('proses-upload-event');
Route::get('/get_list_option_lokasi', $controller_path . '\pages\Page2@get_list_lokasi')->name('list-option-lokasi');
Route::get('/get_grafik_ach_event', $controller_path . '\pages\Page2@get_grafik_ach')->name('grafik-achivement');
Route::get('/print_approval_event', $controller_path . '\pages\Page2@print_approval')->name('print-approval-event')->middleware('ensure.user');
Route::get('/export_data_event', $controller_path . '\pages\Page2@export_event_xls')->name('export-event-xls');
Route::post('/proses_cancel_report', $controller_path . '\pages\Page2@proses_cancel_report')->name('proses-cancel-event');

Route::prefix('events')->group(function () {
  Route::get('/test_event', [Page2::class, 'event_test'])->name('test-event')->middleware('ensure.user');
});

// master lokasi
Route::get('/list-lokasi', $controller_path . '\pages\LokasiController@list_lokasi')->name('list-lokasi')->middleware('ensure.user');
Route::get('/get-list-lokasi', $controller_path . '\pages\LokasiController@getListLokasi')->name('get-list-lokasi');
Route::get('/input-lokasi', $controller_path . '\pages\LokasiController@index')->name('input-lokasi')->middleware('ensure.user');
Route::post('/proses_create_lokasi', $controller_path . '\pages\LokasiController@prosesCreateLokasi')->name('pages-save-lokasi');

// banner bonect
Route::get('/list-banner', $controller_path . '\pages\BannerController@index')->name('list-banner')->middleware('ensure.user');
Route::get('/get_data_list_banner', $controller_path . '\pages\BannerController@getListBanner')->name('pages-get-data-banner');
Route::get('/input-banner', $controller_path . '\pages\BannerController@pageUploadBanner')->name('input-banner')->middleware('ensure.user');
Route::post('/proses-upload-banner', $controller_path . '\pages\BannerController@prosesUploadBanner')->name('proses-upload-banner');
Route::get('/edit-status-banner', $controller_path . '\pages\BannerController@gantiStatusBanner')->name('edit-status-banner')->middleware('ensure.user');
Route::get('storage_banner/{filename}', function ($filename) {
  $path = $_SERVER['DOCUMENT_ROOT'] . "/bsc_file/" . $filename;

  if (!File::exists($path)) {
    abort(404);
  }

  $file = File::get($path);
  $type = File::mimeType($path);

  $response = Response::make($file, 200);
  $response->header("Content-Type", $type);

  return $response;
});

// calendar event
Route::get('/calendar-event', $controller_path . '\pages\CalendarEventController@list_event')->name('calendar-event')->middleware('ensure.user');
Route::get('/get_data_list_event_calendar', $controller_path . '\pages\CalendarEventController@get_data_list_event')->name('pages-get-data-event-calendar');
Route::get('/edit-status-calendar', $controller_path . '\pages\CalendarEventController@gantiStatusCalendar')->name('edit-status-calendar')->middleware('ensure.user');

// pages
Route::get('/pages/misc-error', $controller_path . '\pages\MiscError@index')->name('pages-misc-error');

// authentication
Route::get('/auth/login', $controller_path . '\authentications\LoginBasic@index')->name('auth-login');
Route::post('/auth/login_proses', $controller_path . '\authentications\LoginBasic@login_proses')->name('auth-login-proses');
Route::get('/auth/register-basic', $controller_path . '\authentications\RegisterBasic@index')->name('auth-register-basic');
Route::post('/auth/logout', $controller_path . '\authentications\LoginBasic@logout_proses')->name('auth-logout-proses');
Route::get('/auth/notif', $controller_path . '\authentications\Notifs@index')->name('auth-notif');
Route::get('/auth/log_to_in', $controller_path . '\authentications\LoginBasic@log_to_in_proses')->name('auth-logtoin')->middleware('corsx');
Route::get('/auth/test_login', $controller_path . '\authentications\LoginBasic@test_login_proses')->name('auth-test-login');

// route to ex image2
Route::get('storage_event/{filename}', function ($filename) {
  $path = $_SERVER['DOCUMENT_ROOT'] . "/event_file/" . $filename;

  if (!File::exists($path)) {
    abort(404);
  }

  $file = File::get($path);
  $type = File::mimeType($path);

  $response = Response::make($file, 200);
  $response->header("Content-Type", $type);

  return $response;
});

// finance route
Route::middleware('ensure.user')->prefix('/finance')->group(function () {
  // coa
  Route::get('/coa', 'App\Http\Controllers\finance\CoaController@getAllAkun')->name('finance-coa');
  // edit coa
  Route::get('/edit-coa/{id}', 'App\Http\Controllers\finance\CoaController@editCoa')->name('edit-coa');
  // update coa
  Route::put('/update-coa/{id}', 'App\Http\Controllers\finance\CoaController@updateCoa')->name('update-coa');

  // arus kas
  Route::get('/arus-kas', 'App\Http\Controllers\finance\ArusKasController@index')->name('finance-arus-kas');
  Route::post('/arus-kas', 'App\Http\Controllers\finance\ArusKasController@filterDataArusKas')->name('finance-filter-arus-kas');

  Route::get('/arus-kas-example', 'App\Http\Controllers\finance\ArusKasController@aruskasexample')->name('finance-arus-kas-example');

  Route::get('/arus-kas-export', 'App\Http\Controllers\finance\ArusKasController@aruskasExport')->name('finance-arus-kas-export');
});

// route
Route::get('/pricelists', 'App\Http\Controllers\pricelist\PricelistController@index')->name('pricelists')->middleware('ensure.user');
Route::post('/import-template', [PricelistController::class, 'templateImport'])->name('template-import-pricelist')->middleware('ensure.user');
Route::post('/export-pricelist', [PricelistController::class, 'exportPricelist'])->name('template-export-pricelist')->middleware('ensure.user');
