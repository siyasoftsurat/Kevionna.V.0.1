<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');
Route::group(['middleware' => 'auth:api'], function(){
		Route::post('details', 'API\UserController@details');
		Route::get('logout', 'API\UserController@logout');

		Route::post('addCategory', 'API\CategoryController@store');
		Route::get('Category', 'API\CategoryController@index');
		Route::get('showCategory/{Category}', 'API\CategoryController@show');
		Route::post('editCategory/{Category}', 'API\CategoryController@update');
		Route::delete('deleteCategory/{Category}', 'API\CategoryController@destroy');

		Route::post('addBennar','API\BennarController@store');
		Route::get('Bennar','API\BennarController@index');
		Route::get('showBennar/{bennar}','API\BennarController@show');
		Route::post('editBennar/{bennar}','API\BennarController@update');
		Route::delete('deleteBennar/{bennar}','API\BennarController@destroy');
});
