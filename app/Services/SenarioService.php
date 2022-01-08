<?php

namespace App\Services;

use \Validator;
use \Storage;

use App\Models\Admin;
use App\Models\Senario;
use App\Models\Bot;
use Carbon\Carbon;

class SenarioService
{
  public function add($botId) {
    Validator::make([
      "bot_id" => $botId
    ], [
      'bot_id' => 'required|exists:bots,id',
    ])->validate();

    $senario = Senario::create([
      "name" => "新しいシナリオ",
      "bot_id" => $botId
    ]);
    return $senario;
  }

  public function validate($data){
    Validator::make($data, [
      'name' => 'string',
      'priority' => 'integer',
      'is_valid' => 'integer',
    ])->validate();
  }

  public function edit($senarioId, $data) {

    $senario = Senario::find($senarioId);

    $this->validate( collect( $senario->toArray() )->merge($data)->toArray() );
    $senario->fill( $data );
    $senario->save();

    return $senario;
  }

  public function copy($senarioId) {

    $senario = Senario::with(["rules.actions"])->find($senarioId);

    $newSenario = $senario->copy();

    return $newSenario;
  }

  public function delete($senarioId) {
    $senario = Senario::find($senarioId);
    $senario->delete();

    $accounts = $senario->accounts;

    $bot = Bot::with(["senarios"])->find( $senario->bot_id );

    $accounts->each( function($account) use ($bot){
      $senario = $bot->checkApplicableSenario($account);
      if( $senario ){
        $account->senario_id = $senario->id;
        $account->save();
      }
    });

    return $senario;
  }
}