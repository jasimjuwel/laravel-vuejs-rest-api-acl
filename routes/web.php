<?php



Route::get('/', 'LoginController@index');
Route::get('admin-login', 'LoginController@index');
Route::get('login', 'LoginController@index');
Route::post('login', ['as' => 'login', 'uses' => 'LoginController@Auth']);

Route::get('forgot-password', 'UserManagement\UserRegistrationController@showLinkRequestForm');
Route::post('user-password/email',['as' => 'user-password.email', 'uses'=>'UserManagement\ForgotPasswordController@sendResetLinkEmail']);
Route::get('user-password/reset/{token}', ['as' => 'user-password.reset.token', 'uses'=>'UserManagement\PasswordResetController@showResetForm']);
Route::post('user-password/reset/', ['as' => 'user-password.reset', 'uses'=>'UserManagement\PasswordResetController@reset']);

Route::group(['middleware' => ['preventbackbutton', 'auth']], function () {

    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('logout', 'LoginController@logout');
    Route::resource('user', 'UserManagement\UserController', ['parameters' => ['user' => 'id']]);
    Route::resource('role', 'UserManagement\RoleController', ['parameters' => ['role' => 'id']]);
    Route::resource('department', 'UserManagement\DepartmentController', ['parameters' => ['department' => 'id']]);
    Route::group(['prefix' => 'menu-permission'], function () {
        Route::get('/', ['as' => 'menu-permission.index', 'uses' => 'UserManagement\PermissionController@index']);
        Route::post('/store', ['as' => 'menu-permission.store', 'uses' => 'UserManagement\PermissionController@store']);
    });
    Route::post('get-all-menus', 'UserManagement\PermissionController@getAllMenus');
    Route::resource('change-password', 'UserManagement\ChangePassword');
});
Route::get('user-registration', 'UserManagement\UserRegistrationController@index');
Route::post('user-registration-save', 'UserManagement\UserRegistrationController@createUser');


/*-------------Soap Api-----------------*/

Route::get('/checkvat', ['as' => 'checkvat', 'uses' => 'SoapApi\SoapController@checkVat']);
Route::get('/checkholiday', ['as' => 'checkholiday', 'uses' => 'SoapApi\SoapController@CheckHoliday']);
Route::get('/capital-city', ['as' => 'capital-city', 'uses' => 'SoapApi\SoapController@getCapitalCitys']);
Route::get('/weather', ['as' => 'capital-city', 'uses' => 'SoapApi\SoapController@getWeather']);
Route::get('/geoip', ['as' => 'capital-city', 'uses' => 'SoapApi\SoapController@getIP']);
Route::get('/test', ['as' => 'capital-city', 'uses' => 'SoapApi\SoapController@test']);

