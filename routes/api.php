<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('docker')->group(function () {
    Route::post('/container/execute', 'API\DockerCommandController@execute')->name('docker.container.execute');
    Route::get('/containers', 'API\DockerCommandController@index')->name('docker.container.index');
    Route::get('/container/{id}', 'API\DockerCommandController@show')->name('docker.container.show');
});

Route::prefix('grp')->group(function () {
    Route::post('/deploy/execute-deploy', 'API\GRPCommandController@executeDeploy')->name('grp.deploy.executeDeploy');
    Route::post('/migration/execute-migration', 'API\GRPCommandController@executeMigration')->name('grp.migration.executeMigration');
});

Route::prefix('postgresql')->group(function () {
    Route::post('/log/view', 'API\PostgresqlCommandController@view')->name('postgresql.log.view');
    Route::post('/log/remove', 'API\PostgresqlCommandController@remove')->name('postgresql.log.remove');
    Route::post('/log/clear', 'API\PostgresqlCommandController@clear')->name('postgresql.log.clear');
    Route::get('/logs', 'API\PostgresqlCommandController@list')->name('postgresql.log.list');
    Route::post('/log/create', 'API\PostgresqlCommandController@create')->name('postgresql.log.create');
});
