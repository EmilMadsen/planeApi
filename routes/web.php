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

use App\Http\UseCases\CrawlPage;

Route::get('/', function () {

    return (new CrawlPage('https://www.cph.dk/flyinformation/ankomster'))->handle();

});

Route::get('/{type}', 'ScrapeController@retrieve');
