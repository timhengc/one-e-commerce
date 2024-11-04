const mix = require('laravel-mix');

mix.setPublicPath('public')
    .css('packages/Webkul/Blog/src/Resources/assets/css/custom.css', 'public/themes/shop/default/build/assets')
