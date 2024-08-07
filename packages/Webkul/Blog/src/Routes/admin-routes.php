<?php

/*
 *
 * 这是用于扩展Blog功能的包，真正的Blog代码在vendor/webbycrown/blog-for-bagisto/
 *
 */

//use Illuminate\Support\Facades\Route;
//use Webkul\Blog\Http\Controllers\Admin\BlogController;
//use Webkul\Blog\Http\Controllers\Admin\CustomCategoryController;

//Route::group(['middleware' => ['web', 'admin'], 'prefix' => 'admin/blog'], function () {
//    Route::controller(BlogController::class)->group(function () {
//        Route::get('', 'index')->name('admin.blog.index');
//    });
//});

//Route::get('admin/blog/category', function () {
//    return response()->json(['message' => 'Route successfully overridden1']);
//})->name('admin.blog.category.index');

//Route::group(['middleware' => ['web', 'admin'], 'prefix' => config('app.admin_url')], function () {

//    Route::get('blog/category', [CustomCategoryController::class, 'index'])->defaults('_config', [
//        'view' => 'blog::admin.categories.index',
//    ])->name('admin.blog.category.index');

//    Route::get('blog/category', function () {
//        return response()->json(['message' => 'Route successfully overridden1213']);
//    })->name('admin.blog.category.index');
//});
