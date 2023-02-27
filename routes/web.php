<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\branchController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\userMagController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DropdownController;
use App\Http\Controllers\DeanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserhomeController;
use App\Http\Controllers\StaffController;
use App\Http\Middleware\IsAdmin;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
	return view('/auth.login');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home/dean', [App\Http\Controllers\DeanController::class, 'index'])->name('homeDean.ajax');
Route::get('/home2', [App\Http\Controllers\HomeController::class, 'index2'])->name('home2');
Route::get('/home/staff', [App\Http\Controllers\StaffController::class, 'loadDocs'])->name('homestaff.ajax');
Route::get('/home/user', [App\Http\Controllers\UserhomeController::class, 'loadAllDocs'])->name('homeUser');

Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');


Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile/update', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	// Route::post('/profile/update',[ProfileController::class,'updateProfile'])->name('updateProfile');
	// Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);

	//admin
	Route::get('/admin/all', [adminController::class, 'index'])->name('admin');
	Route::get('/admin/userMag', [userMagController::class, 'index'])->name('userMag.ajax');
	Route::get('/admin/branchMag', [branchController::class, 'index'])->name('branchMag.ajax');
	Route::get('/document/general/all', [DocumentController::class, 'docsAll'])->name('generalDocs.ajax');
	Route::get('/document/general2/all', [DocumentController::class, 'docsAll2'])->name('generalDocs2.ajax');
	//	Route::get('/document/all', [DocumentController::class, 'index'])->name('document');
	// user
	Route::get('/home/AllDoc', [HomeController::class, 'allDocs'])->name('AllDocs');
	Route::get('/home/user/UserDocsAll', [UserhomeController::class, 'UserDocsAll'])->name('UserDocsAll');

	Route::get('/home/staff/StaffDocsAll', [StaffController::class, 'StaffDocsAll'])->name('StaffDocsAll.ajax');


	//ADD
	Route::post('/admin/branchMag/add', [branchController::class, 'store'])->name('addBranch');
	Route::post('/admin/userMag/add', [userMagController::class, 'store'])->name('addUser');
	Route::post('/document/docsType/add', [DocumentController::class, 'storeType'])->name('addDocsType');
	Route::post('/document/government/add', [DocumentController::class, 'storeGovern'])->name('addGovernment');
	Route::post('/document/add', [DocumentController::class, 'storeDocument'])->name('addDocument');
	Route::post('/document/dean/send', [DeanController::class, 'addMessenger'])->name('addMessenger');

	//delete
	Route::get('/admin/branchMag/delete/{id}', [branchController::class, 'delete']);

	//edit
	Route::post('/admin/userMag/edit/{id}', [userMagController::class, 'edit']);
	// Route::post('/document/docs/edit/{id}',[DocumentController::class,'loadEdit']);

	//update
	Route::post('/admin/branchMag/update/{id}', [branchController::class, 'update']);
	Route::post('/admin/userMag/update/{id}', [userMagController::class, 'update']);
	Route::post('/document/docs/edit/', [DocumentController::class, 'updateDoc'])->name('updateDoc');
	//document

	Route::get('/document/docsType', [DocumentController::class, 'docsType'])->name('docsType');

	// dropdown 
	Route::get('/permission', 'DropdownController@index');
	Route::post('/permission/fetch', 'DropdownController@fetch')->name('dropdown.fetch');
	// Route::get('permission/{id}', [DropdownController::class, 'getUser']);
	// Route::get('/','DropdownController@index');


	//reactive 
	Route::get('/document/reactive', [StaffController::class, 'updateReactive'])->name('updateReactive');
	Route::get('/document/user/reactive', [UserhomeController::class, 'updateReactive'])->name('userReactive');
});
