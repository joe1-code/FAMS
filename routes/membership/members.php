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
            return view('backend.membership.index');
        })->name('index');


        Route::group(['prefix' => 'register_member',  'as' => 'register_member'], function() {

            Route::get('/', 'memberController@index')->name('index');
            // Route::get('report', 'OshAuditController@indexReport')->name('report');
            

            
        });

    });

});
