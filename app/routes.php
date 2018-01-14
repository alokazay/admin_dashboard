<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'MainController@indexAction');
Route::get('/login', 'MainController@indexAction');
Route::post('/login', 'MainController@loginAction');

Route::get('/logout', 'MainController@logoutAction');

Route::get('/dashboard', array('before' => 'auth', 'uses' => 'DashboardController@indexAction'));

Route::get('/dashboard/users', array('before' => 'auth', 'uses' => 'DashboardController@usersAction'));
Route::post('/dashboard/users', array('before' => 'auth|csrf', 'uses' => 'DashboardController@ajaxAction'));
Route::post('/dashboard/task', array('before' => 'auth', 'uses' => 'DashboardController@addTaskAction'));

Route::get('/dashboard/tasks', array('before' => 'auth', 'uses' => 'DashboardController@tasksAction'));

Route::filter('auth', function() {  if (Auth::guest()) return Redirect::guest('/'); });
Route::filter('csrf', function() {
    $token = Request::ajax() ? Request::header('X-CSRF-Token') : Input::get('_token');
    if (Session::token() != $token) {
        throw new Illuminate\Session\TokenMismatchException;
    }
});