<?php

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
    return view('welcome');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/image-editor', array('as' => 'image-editor', function()
{
   return view('image-editor');
}));

Route::get('/my-projects', array('as' => 'my-projects', function()
{
   return view('my-projects');
}));

//posto ovde nemma controllera moram auth ovde odma
/* Route::group(['middleware' => ['auth']], function () {     
    Route::get('/my-projects', function () {
        return view('my-projects');
    });
}); */
