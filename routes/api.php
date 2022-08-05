<?php

use Illuminate\Http\Request;

Route::namespace('Api\Rest')->prefix('/rest/v1')->group( function() {
  Route::post('/line/webhook/{hash}', 'LineBotController@webhook')->name('api.line.webhook');
  Route::get('/line/webhook/{hash}', 'LineBotController@webhook');

  Route::get('/logizard', 'OutboundController@logizard')->name('api.outbound.logizard');
  Route::get('/relation', 'OutboundController@relation')->name('api.outbound.relation');
});