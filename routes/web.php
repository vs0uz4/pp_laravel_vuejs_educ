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

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'admin'], function (){

    // Auth Group Routes...
    Route::group(['namespace'=>'Auth\\', 'as'=>'auth.'], function (){
        // Authentication Routes...
        Route::get('login',     'LoginController@showLoginForm')->name('login');
        Route::post('login',    'LoginController@login');
        Route::post('logout',   'LoginController@logout')->name('logout');

        // Forgot Password Routes...
        Route::get('password/reset',    'ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/email',   'ForgotPasswordController@sendResetLinkEmail')->name('password.email');


        // Password Reset Routes...
        Route::get('password/reset/{token}','ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset',       'ResetPasswordController@reset');
    });
/*
|        | GET|HEAD  | admin/login                  | login               | SiGeEdu\Http\Controllers\Auth\LoginController@showLoginForm                | web,guest    |
|        | POST      | admin/login                  |                     | SiGeEdu\Http\Controllers\Auth\LoginController@login                        | web,guest    |
|        | POST      | admin/logout                 | logout              | SiGeEdu\Http\Controllers\Auth\LoginController@logout                       | web          |

|        | POST      | admin/password/email         | password.email      | SiGeEdu\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail  | web,guest    |
|        | POST      | admin/password/reset         |                     | SiGeEdu\Http\Controllers\Auth\ResetPasswordController@reset                | web,guest    |
|        | GET|HEAD  | admin/password/reset         | password.request    | SiGeEdu\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm | web,guest    |
|        | GET|HEAD  | admin/password/reset/{token} | password.reset      | SiGeEdu\Http\Controllers\Auth\ResetPasswordController@showResetForm        | web,guest    |

|        | POST      | admin/register               |                     | SiGeEdu\Http\Controllers\Auth\RegisterController@register                  | web,guest    |
|        | GET|HEAD  | admin/register               | register            | SiGeEdu\Http\Controllers\Auth\RegisterController@showRegistrationForm      | web,guest    |
*/


    Route::group(['namespace'=>'Admin\\', 'as'=>'admin.', 'middleware'=>'auth'], function(){
        // Support Route...
        Route::get('/sysinfo', function() {
            return 'System Informations...';
        });

        // Users Route..
        Route::resource('users', 'UsersController');
    });

});

Route::get('/home', 'HomeController@index')->name('home');
