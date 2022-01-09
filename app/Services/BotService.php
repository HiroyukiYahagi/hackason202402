<?php

namespace App\Services;

use \Validator;
use \Storage;

use App\Models\Admin;
use App\Models\Bot;
use Carbon\Carbon;

class BotService
{
  protected $lineBotService;

  public function __construct(LineBotService $lineBotService){
    $this->lineBotService = $lineBotService;
  }

  public function add($adminId) {
    Validator::make([
      "admin_id" => $adminId
    ], [
      'admin_id' => 'required|exists:admins,id',
    ])->validate();

    $bot = Bot::create([
      "name" => "新しいボット",
      "admin_id" => $adminId,
      "hash" => \Str::random(8)
    ]);
    return $bot;
  }

  public function edit($id, $data) {
    $bot = Bot::find($id);
    
    Validator::make(collect( $bot->toArray() )->merge($data)->toArray(), [
      'admin_id' => 'required|exists:admins,id',
    ])->validate();

    $bot->fill($data);
    $bot->save();
    
    return $bot;
  }

  public function recalc($id) {
    $bot = Bot::find($id);

    $bot->accounts->each(function($account) use ($bot){
      $senario = $bot->checkApplicableSenario($account);
      if( $senario ){
        $account->senario_id = $senario->id;
        $account->save();
      }
    });

    return $bot;
  }

  public function delete($id) {
    $bot = Bot::find($id);
    $bot->delete();

    return $bot;
  }

  public function setRichMenu($id, $data){
    $bot = Bot::find($id);

    $data["rich_menu_id"] = $this->lineBotService->setRichMenu($bot, $data["rich_menu"], $data["rich_menu_url"], true);

    if( $data["rich_menu_id"] == null ){
      return null;
    }
    
    $bot->fill($data);
    $bot->save();

    return $bot;
  }
}