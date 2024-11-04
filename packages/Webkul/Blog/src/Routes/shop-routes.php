<?php

use Illuminate\Support\Facades\Route;
use Webkul\Blog\Http\Controllers\Shop\BlogController;

// Route::get('blog/{slug}', [BlogController::class, 'show'])->name('shop.blog.show');
//Route::group(['middleware' => ['web', 'theme', 'locale', 'currency'], 'prefix' => 'blog'], function () {
//    Route::get('', [BlogController::class, 'index'])->name('shop.blog.index');
//});

Route::group([
    'prefix' => 'blog',
    'middleware' => ['web', 'theme', 'locale', 'currency']
], function () {
    Route::get('/{slug}/{blog_slug?}', [BlogController::class, 'view'])->defaults('_config', [
        'view' => 'blog::shop.velocity.view',
    ])->name('shop.article.view');
});
