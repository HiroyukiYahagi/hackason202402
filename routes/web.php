<?php

Route::get('/', "RootController@index")->name("root.index");


Route::namespace("Admin")->prefix('admin')->group( function() {
  Route::get('/login', "AuthController@showLoginForm")->name("admin.login");
  Route::post('/login', "AuthController@login");
  Route::get('/logout', "AuthController@logout")->name("admin.logout");

  Route::get('/', "IndexController@index")->name("admin.index");
  Route::post('/edit', "IndexController@edit")->name("admin.edit");


  Route::get('/bots', "BotController@index")->name("admin.bots.index");
  Route::post('/bots', "BotController@add")->name("admin.bots.add");

  Route::prefix('bots/{bot}')->group( function() {
    Route::get('/', "BotController@view")->name("admin.bots.view");
    Route::get('/edit', "BotController@showEdit")->name("admin.bots.edit");
    Route::post('/edit', "BotController@edit");
    Route::post('/delete', "BotController@delete")->name("admin.bots.delete");

    Route::post('/recalc', "BotController@recalc")->name("admin.bots.recalc");

    Route::get('/senarios', "SenarioController@index")->name("admin.senarios.index");
    Route::post('/senarios/add', "SenarioController@add")->name("admin.senarios.add");

    Route::prefix('senarios/{senario}')->group( function() {
      Route::get('/', "SenarioController@view")->name("admin.senarios.view");
      Route::post('/edit', "SenarioController@edit")->name("admin.senarios.edit");
      Route::post('/copy', "SenarioController@copy")->name("admin.senarios.copy");
      Route::post('/delete', "SenarioController@delete")->name("admin.senarios.delete");

      Route::get('/rules', "RuleController@index")->name("admin.rules.index");
      Route::post('/rules/add', "RuleController@add")->name("admin.rules.add");
      Route::prefix('rules/{rule}')->group( function() {
        Route::get('/', "RuleController@view")->name("admin.rules.view");
        Route::post('/copy', "RuleController@copy")->name("admin.rules.copy");
        Route::post('/edit', "RuleController@edit")->name("admin.rules.edit");
        Route::post('/delete', "RuleController@delete")->name("admin.rules.delete");

        Route::post('/actions', "RuleController@actions")->name("admin.rules.actions");

      });

      Route::get('/accounts', "SenarioController@accounts")->name("admin.senarios.accounts");
    });

    Route::prefix('accounts')->group( function() {
      Route::get('/', "AccountController@index")->name("admin.accounts.index");
      Route::get('/{account}', "AccountController@view")->name("admin.accounts.view");
      Route::post('/{account}/edit', "AccountController@edit")->name("admin.accounts.edit");
      Route::post('/{account}/property', "AccountController@property")->name("admin.accounts.property");
    });
  });

  Route::prefix('assets')->group( function() {
    Route::get('/', "AssetController@index")->name("admin.assets.index");
    Route::post('/add', "AssetController@add")->name("admin.assets.view");
    Route::post('/{asset}/delete', "AssetController@delete")->name("admin.assets.delete");
  });

});



