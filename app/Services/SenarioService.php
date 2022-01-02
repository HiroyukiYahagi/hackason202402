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
      "bot_id" => $botId,
      "hash" => \Str::random(8)
    ]);
    return $senario;
  }
}