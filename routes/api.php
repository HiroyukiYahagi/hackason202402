<?php

use Illuminate\Http\Request;

Route::namespace('Api\Rest')->prefix('/rest/v1')->group( function() {
  Route::post('/line/webhook', 'LineBotController@webhook')->name('line.webhook');
});