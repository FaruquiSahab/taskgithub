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

Route::get('/', 'HandleClosureController@welcome');


// Dasborad Protected Route
Route::group(['middleware' => ['authorize', 'auth']], function ()
{
    Route::get('/home', [
        'name' => 'home',
        'as' => 'home',
        'uses' => 'HomeController@home',
    ]);
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/authorize/{token}', [
        'name' => 'Authorize Login',
        'as' => 'authorize.device',
        'uses' => 'AuthorizeController@verify',
    ]);

    Route::post('/authorize/resend', [
        'name' => 'Authorize',
        'as' => 'authorize.resend',
        'uses' => 'AuthorizeController@resend',
    ]);
});
// end



// users index page
Route::get('/users','TestController@usersindex')->name('users.index');

// Edit User Info
Route::post('/edit/user','TestController@edituser')->name('users.edit');

// Laravel Auth Routes
Auth::routes();

// // Index Page
// Route::get('/home', 'HomeController@index')->name('home');

// Encrypt Req And Forward For Proceeding
Route::POST('/encrypt/request', 'TestController@takeRequest')->name('takeRequest');

// Resources ROUTES for Students CRUD
Route::resource('/students','TestController');

// Resources ROUTES for Events CRUD
Route::resource('/events','EventController');

// Separate Update Route
Route::POST('/students/update/{id}','TestController@update');

// Route For DataTable of Students
Route::get('/studentsData','TestController@studentsData')->name('studentdata');

// View Specific File of Student
Route::get('/viewfile/{id}','TestController@viewfile')->name('viewfile');

// Test Check Routes
Route::get('/charts/values','HomeController@chartValues');

Route::group(['middleware' => ['authorize']], function () {
    // Google Login Redirect and Callback Routes
    Route::get('/redirect', 'AuthGoogleController@redirect');
    Route::get('/callback', 'AuthGoogleController@callback');
});
// Routes For Two Factor Validation

	// Enable Two Factor Generate Code
	Route::get('/2fa/enable', 'Google2FAController@enableTwoFactor');
	
	//  Disable Two Factor Form
	Route::get('/2fa/disable/form', 'Google2FAController@disableTwoFactorForm');

	//  Disable Two Factor
	Route::get('/2fa/disable', 'Google2FAController@disableTwoFactor');
	
	// Get Two Factor Validate Route
	Route::get('/2fa/validate', 'Auth\LoginController@getValidateToken');
	
	// Verify Token
	Route::post('/2fa/validate', ['middleware' => 'throttle:5', 'uses' => 'Auth\LoginController@postValidateToken']);
// 

