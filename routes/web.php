<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


Route::group(['middleware' => ['web']], function(){
	
	//Welcome Page
	Route::get('/', function () {
		return view('welcome');
	});

	Route::get('/','WelcomeController@index');

	//Login Page
	Route::get('login',function(){
		return view('login');
	});

	// Register Page
	Route::get('register',function(){
		return view('register');
	});
	Route::post('userregister', 'RegisterController@registerUser');
	
	Route::post('workorderindex', 'LoginController@checkLogin');
	
	//One Key Order
	Route::get('workorder', 'WorkOrderController@index');
	Route::get('ajax-city', 'WorkOrderController@getCity');
	Route::post('createwo', 'WorkOrderController@createWO');
	
	Route::get('uploadwo',function(){
		return view('uploadwo');
	});
	Route::post('uploadWO', 'WorkOrderController@uploadWO');
	
	//WO Management
	Route::get('womanagement', 'WOManagementController@getWOInfo');
	Route::post('editwo', 'WOManagementController@editWO');
	Route::post('searchWO', 'WOManagementController@searchWO');
});