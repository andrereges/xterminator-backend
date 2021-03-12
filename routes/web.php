<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'AppController@index')->name('app.index');
Route::get('/{vue?}', 'AppController@vue')->where('vue', '[\/\w\.-]*')->name('app.vue');
