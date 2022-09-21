<?php

use Illuminate\Support\Facades\Route;
use Illuminate\support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FrontendController;
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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/',[FrontendController::class, 'welcome']);

Auth::routes();
// deshboard
Route::get('/home', [HomeController::class, 'index'])->name('home');
// deshboard
// users part
Route::get('/users', [AdminController::class, 'users'])->name('user.list');
Route::get('/user/delete/{user_id}', [AdminController::class, 'users_delete'])->name('user.delete');
Route::get('user/Profile', [AdminController::class, 'user_profile'])->name('user.profile');
Route::post('user/Password/Update', [AdminController::class, 'pass_Update'])->name('pass.update');
Route::post('user/Profile/Update', [AdminController::class, 'Update_profile'])->name('profile.update');
Route::post('/upname', [AdminController::class, 'name_up']);
// users part
// category part
Route::get('Category', [CategoryController::class, 'category'])->name('category');
Route::post('/CatADD', [CategoryController::class, 'cat_insert'])->name('add.route');
Route::get('/CatEditPage/{cat_editid}', [CategoryController::class, 'cat_edit_page'])->name('cat.edit');
Route::post('/CatEdit', [CategoryController::class, 'cat_edit'])->name('category.edit');
Route::get('/catsoft/del/{cat_id}', [CategoryController::class, 'catagory_soft_delete'])->name('cat.softdelete');
Route::post('/mark/delete', [CategoryController::class, 'mark_delete']);
Route::get('/Trushed/Categories', [CategoryController::class, 'trushed'])->name('trushed');
Route::post('/mark/hard/delete', [CategoryController::class, 'hard_delete'])->name('hard.delete');
Route::get('/restore/{restore_id}', [CategoryController::class, 'restore'])->name('re.store');
// category part
