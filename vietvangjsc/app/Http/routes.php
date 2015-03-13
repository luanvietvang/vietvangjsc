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
//Default route
Route::get('/', 'HomeController@index');
Route::get('home.html', 'HomeController@index');

//Langauge route
Route::get('home-{lang?}.html', 'HomeController@index');
Route::get('director-greeting-{lang?}.html', 'HomeController@showGreeting');
Route::get('company-overview-{lang?}.html', 'HomeController@showOverview');
Route::get('tools-to-use-{lang?}.html', 'HomeController@showToolToUse');
Route::get('working-process-{lang?}.html', 'HomeController@showWorkingProcess');
Route::get('resource-education-{lang?}.html', 'HomeController@showResourceEducation');
Route::get('{categoryName?}-c{category?}-{lang?}.html', 'HomeController@showProducts')
			->where(array(
							'categoryName' => '[A-Za-z0-9_-]+',
							'category' => '[0-9]+'
						));
Route::get('products-{lang?}.html', 'HomeController@showAllProducts');
Route::get('{productName?}-p{productId}-{lang?}.html', 'HomeController@showProduct')
			->where(array(
							'productName' => '[A-Za-z0-9_-]+',
							'productId' => '[0-9]+'
						));
Route::get('news-{lang?}.html', 'HomeController@showNews');
Route::get('{newName?}-n{newId?}-{lang?}.html', 'HomeController@showNew')
			->where(array(
							'newName' => '[A-Za-z0-9_-]+',
							'newId' => '[0-9]+'
						));
Route::get('for-staff-{lang?}.html', 'HomeController@showForStaff');
Route::get('recruitment-{lang?}.html', 'HomeController@showRecruitments');
Route::get('{recruitmentName?}-n{recruitmentId?}-{lang?}.html', 'HomeController@showRecruitments')
			->where(array(
							'recruitmentName' => '[A-Za-z0-9_-]+',
							'recruitmentId' => '[0-9]+'
						));
Route::get('contact-us-{lang?}.html', 'HomeController@showContactUs');
Route::post('sendMail', 'HomeController@sendEmail');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

//ADMIN
//Default route
Route::get('admin', 'AdminController@index');
Route::get('admin/index', 'AdminController@index');
Route::any('admin/articles', 'AdminController@articles');
Route::any('admin/articles/add', 'AdminController@articlesAdd');
Route::any('admin/articles/del/{id?}', 'AdminController@articlesDel')->where(array('id' => '[0-9]+'));
//Route::get('admin/articles/?page={no}', 'AdminController@articles')->where(array('no' => '[0-9]+'));
//Route::get('admin/categories', 'AdminController@categories');
Route::get('admin/menus', 'AdminController@menus');
Route::get('admin/products', 'AdminController@products');
