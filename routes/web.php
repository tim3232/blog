<?php

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
//

Auth::routes();
Route::get('/', function () {
        return redirect('posts');
    });
Route::get('posts', 'MainController@posts')->name('posts');
Route::get('posts/{id}', 'MainController@post')->name('post');

Route::get('/verify/{token}', '\App\Http\Controllers\Auth\RegisterController@verify')->name('register.verify');

Route::group(['middleware' => 'auth'], function () {

    Route::post('create/comment', 'MainController@create_comment')->name('create-comment');
    Route::post('create/post', 'MainController@create_post')->name('create-post');
    Route::post('update/{id}/post', 'MainController@update_post')->name('update-post');
    Route::get('delete/{id}/post', 'MainController@delete_post')->name('delete-post');
    Route::get('delete/{id}/comment', 'MainController@delete_comment')->name('delete-comment');

    Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
});