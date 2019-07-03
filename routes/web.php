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
    Route::resource('projectdevelopers', 'ProjectDeveloperController');
    Route::resource('fixedcost', 'FixedCostController');
    Route::resource('variablecost', 'FixedCostController');
    Route::resource('others', 'FixedCostController');
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
