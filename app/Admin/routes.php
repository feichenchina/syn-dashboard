<?php
use Encore\Admin\Facades\Admin;
use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
    'as' => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('teachers', TeacherController::class)->middleware('checkAuth:teacher');
    $router->resource('students', StudentController::class)->middleware('checkAuth:student');
    $router->get('auth/login', 'AuthController@getLogin');
    $router->post('auth/login', 'AuthController@postLogin');
});

// 允许administrator、editor两个角色访问group里面的路由
// Route::group([
//     'prefix' => config('admin.route.prefix'),
//     'namespace' => config('admin.route.namespace'),
//     'middleware' => 'admin.permission:allow,administrator,teacher',
//     'as' => config('admin.route.prefix') . '.',
// ], function ($router) {

//     $router->get('/', 'HomeController@index')->name('home');
//     $router->resource('teachers', TeacherController::class);

// });
