<?php

namespace App\Services;

use \Validator;
use \Storage;

use App\Models\Admin;
use App\Models\Bot;
use Carbon\Carbon;

class BotService
{

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

  public function delete($id) {
    $bot = Bot::find($id);
    $bot->delete();

    return $bot;
  }
}