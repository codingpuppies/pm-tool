<?php

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Auth::routes();

/*
|------------------------------------------------------------------------------------
| Admin
|------------------------------------------------------------------------------------
*/
Route::group(['prefix' => ADMIN, 'as' => ADMIN . '.', 'middleware'=>['auth', 'Role:10']], function () {
    Route::get('/', 'DashboardController@index')->name('dash');
    Route::resource('users', 'UserController');
    Route::resource('projects', 'ProjectController');
    Route::resource('developers', 'DeveloperController');
    Route::resource('management', 'ManagementController');
    Route::resource('projectdevelopers', 'ProjectDeveloperController');
    Route::resource('fixedcosts', 'FixedCostController');
    Route::resource('variablecost', 'FixedCostController');
    Route::resource('othercosts', 'OtherCostController');
});

Route::group(['prefix' => ADMIN, 'as' => ADMIN . '.', 'middleware'=>['auth', 'Role:0']], function () {
//    Route::get('/', 'DashboardController@index')->name('dash');
//    Route::resource('users', 'UserController');
//    Route::resource('projects', 'ProjectController');
//    Route::resource('developers', 'DeveloperController');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('admin.dashboard.index');
});
