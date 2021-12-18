<?php

Route::get('/', "RootController@index")->name("root.index");


Route::namespace("Admin")->prefix('admin')->group( function() {
  Route::get('/login', "AuthController@showLoginForm")->name("admin.login");
  Route::post('/login', "AuthController@login");
  Route::get('/logout', "AuthController@logout")->name("admin.logout");

  Route::get('/', "IndexController@index")->name("admin.index");
  Route::post('/edit', "IndexController@edit")->name("admin.edit");


  Route::post('/bots', "BotController@add")->name("admin.bots.add");

  Route::prefix('bots/{bot}')->group( function() {
    Route::get('/', "BotController@view")->name("admin.bots.view");
    Route::post('/edit', "BotController@edit")->name("admin.bots.edit");
    Route::post('/delete', "BotController@delete")->name("admin.bots.delete");

    Route::post('/senarios', "SenarioController@add")->name("admin.senarios.add");
    Route::prefix('senarios/{senario}')->group( function() {
      Route::get('/', "SenarioController@view")->name("admin.senarios.view");
      Route::post('/edit', "SenarioController@edit")->name("admin.senarios.edit");
      Route::post('/delete', "SenarioController@delete")->name("admin.senarios.delete");

      Route::post('/rules', "RuleController@add")->name("admin.rules.add");
      Route::prefix('rules/{rule}')->group( function() {
        Route::get('/', "RuleController@view")->name("admin.rules.view");
        Route::post('/edit', "RuleController@edit")->name("admin.rules.edit");
        Route::post('/delete', "RuleController@delete")->name("admin.rules.delete");

        Route::prefix('actions')->group( function() {
          Route::post('/add', "ActionController@add")->name("admin.actions.add");
          Route::post('/{action}/edit', "ActionController@edit")->name("admin.actions.edit");
          Route::post('/{action}/delete', "ActionController@delete")->name("admin.actions.delete");
        });
      });
    });

    Route::prefix('accounts')->group( function() {
      Route::get('/', "AccountController@index")->name("admin.accounts.index");
      Route::get('/{account}', "AccountController@view")->name("admin.accounts.view");
      Route::post('/{account}/edit', "AccountController@edit")->name("admin.accounts.edit");
    });
  });

  Route::prefix('assets')->group( function() {
    Route::get('/', "AssetController@index")->name("admin.assets.index");
    Route::post('/add', "AssetController@add")->name("admin.assets.view");
    Route::post('/{asset}/delete', "AssetController@edit")->name("admin.assets.edit");
  });

});



