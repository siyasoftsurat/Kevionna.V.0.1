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
		Route::post('details', 'API\CategoryController@store');
		Route::post('updateCompanyInfo/{companyInfo}','API\CompanyInfoController@update');
		Route::get('companyInfo','API\CompanyInfoController@index');

		// social 

		Route::get('socialMedia','API\SocialMediaController@index');
		Route::post('addSocialMedia','API\SocialMediaController@store');
		Route::post('updateSocialMedia/{socialMedia}','API\SocialMediaController@update');
		Route::get('socialMedia/{socialMedia}/edit','API\SocialMediaController@edit');
		Route::delete('socialMedia/{socialMedia}','API\SocialMediaController@destroy');
		
});
