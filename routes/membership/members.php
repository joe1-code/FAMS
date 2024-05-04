<?php

use Illuminate\Support\Facades\Route;

/**
/**
 * MEMBERSHIP
 */
Route::group([
    'namespace' => 'membership',
], function() {



    Route::group(['prefix' => 'membership',  'as' => 'membership'], function() {

        Route::get('/', function () {
            return view('backend.workplace_risk_assesment.menu');
        })->name('menu');


        Route::group(['prefix' => 'register_member',  'as' => 'register_member'], function() {

            Route::get('/', 'memberController@index')->name('index');
            // Route::get('report', 'OshAuditController@indexReport')->name('report');
            

            
        });

    });

});
