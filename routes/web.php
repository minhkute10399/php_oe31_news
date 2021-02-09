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
Route::group(['middleware' => ['localization']], function () {
    Route::group(['middleware' => ['admin']], function () {
        Route::resource('dashboard', 'AdminController')->only('index');
        Route::resource('categories', 'CategoryController');
        Route::get('/postRequest', 'AdminController@showRequestPost')->name('postRequest');
        Route::resource('users', 'UserController');
        Route::resource('comments', 'CommentController');
        Route::get('manageAuthor', 'AuthorController@manageAuthor')->name('manageAuthor');
        Route::get('chart', 'AdminController@updateChart')->name('chart');
    });
    Route::resource('home', 'ClientController');
    Route::resource('posts', 'PostController');
    Route::resource('authors', 'AuthorController');
    Route::get('/filter/{id}', 'ClientController@filterCategory')->name('filterCategory');
    Route::get('/search', 'PostController@search')->name('search');
    Route::post('/like', 'ClientController@postLike')->name('like');
    Route::post('/dislike', 'ClientController@postDisLike')->name('dislike');
    Route::resource('comments', 'CommentController');
    Route::resource('requests', 'RequestAuthorController');
    Route::post('/requestAuthor', 'AuthorController@requestAuthor')->name('requestAuthor');
    Route::get('/writer/{id}', 'AuthorController@postAuthor')->name('postAuthor');
});
Route::get('change-languages/{language}', 'LangController@changeLanguage')->name('change-languages');
Auth::routes();


