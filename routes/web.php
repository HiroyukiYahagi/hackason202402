<?php

Route::get('/', "RootController@index")->name("root.index");
Route::get('/other', "RootController@other")->name("root.other");


Route::namespace("Shop")->group( function(){
  Route::prefix('/shop')->group( function() {
    Route::get('/', "IndexController@index")->name("shop.index");
    Route::get('/edit', "IndexController@edit")->name("shop.edit");
    Route::post('/add', "IndexController@add")->name("shop.add");
    Route::get('/logout', "IndexController@logout")->name("shop.logout");
    Route::get('/login', "IndexController@login")->name("shop.login");

    Route::prefix('/petitions')->group( function() {
      Route::get('/', "PetitionController@index")->name("shop.petitions.index");
      Route::post('/add', "PetitionController@add")->name("shop.petitions.add");
      Route::get('/{petition}', "PetitionController@view")->name("shop.petitions.view");
      Route::post('/{petition}/receipts', "PetitionController@addReceipts")->name("shop.petitions.receipts");
    });

    Route::prefix('/results')->group( function() {
      Route::post('/{result}', "PetitionController@updateResult")->name("shop.results.edit");
    });
    
  });
});


Route::namespace("User")->group( function(){
  Route::prefix('/user')->group( function() {
    Route::get('/', "IndexController@index")->name("user.index");
    Route::get('/edit', "IndexController@edit")->name("user.edit");
    Route::post('/add', "IndexController@add")->name("user.add");
    Route::get('/logout', "IndexController@logout")->name("user.logout");
    Route::get('/login', "IndexController@login")->name("user.login");

    Route::prefix('/donates')->group( function() {
      Route::get('/', "DonateController@index")->name("user.donates.index");
      Route::post('/add', "DonateController@add")->name("user.donates.add");
      Route::get('/{donate}', "DonateController@view")->name("user.donates.view");
      Route::post('/{donate}/vote', "DonateController@vote")->name("user.donates.vote");
    });
    
    Route::prefix('/results')->group( function() {
      Route::post('/{result}', "DonateController@updateResult")->name("user.results.edit");
    });
    Route::prefix('/votes')->group( function() {
      Route::post('/{vote}', "DonateController@updateVotes")->name("user.votes.edit");
    });
  });
});
