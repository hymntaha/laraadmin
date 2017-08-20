<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('admin/importExport', 'UploadMergeController@importExport');
Route::get('admin/downloadExcel/{type}', 'UploadMergeController@downloadExcel');
Route::get('/admin/importExcel', 'UploadMergeController@importExcel');
Route::post('/admin/importExcel', 'UploadMergeController@importExcel');

/* ================== Homepage + Admin Routes ================== */

require __DIR__.'/admin_routes.php';
