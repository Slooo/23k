var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.styles([
    	'../bower/bootstrap/dist/css/bootstrap.min.css',
    	'../bower/font-awesome/css/font-awesome.min.css',
    	'../bower/angular-loading-bar/build/loading-bar.min.css',
    	'main.css',
    ], 'public/css/app.css');

    mix.scripts([
        // all
    	'../bower/jquery/dist/jquery.min.js',
    	'../bower/bootstrap/dist/js/bootstrap.min.js',
    	'../bower/angular/angular.min.js',
    	'../bower/angular-route/angular-route.min.js',
    	'../bower/angular-loading-bar/build/loading-bar.min.js',

    	// angular app
    	'angular/app.js',
    	'angular/services/myServices.js',
    	'angular/helper/myHelper.js',

    	// angular controller
    	'angular/controllers/MainController.js',
    ], 'public/js/app.js');

    mix.version(['css/app.css', 'js/app.js']);
});