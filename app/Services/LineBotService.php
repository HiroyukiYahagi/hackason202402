<?php

namespace App\Services;

use \Validator;
use Illuminate\Support\Facades\Cache;

use App\Models\Bot;
use App\Models\Account;
use App\Models\Message;

use GuzzleHttp\Client as RequestClient;

class LineBotService
{
  public function getProfile($bot, $account){
    try {
        $client = new RequestClient();
        $response = $client->get("https://api.line.me/v2/bot/profile/".$account->hash, [
            'debug' => true,
            'headers' => [
              'Authorization' => 'Bearer '.$bot->channel_access_token
            ],
            'json' => []
        ]);
        $result = json_decode((string) $response->getBody(), true);

        $account->name = $result["displayName"];
        $account->setProperty("thumbnail", $result["pictureUrl"]);
        $account->save();

        return $account;
    } catch (\Exception $e) {
        \Log::error($e);
    }
    return null;
  }


  public function sendMessage($bot, $account, $json){
    try {
        $client = new RequestClient();
        $response = $client->get("https://api.line.me/v2/bot/profile/".$account->hash, [
            'debug' => true,
            'headers' => [
              'Authorization' => 'Bearer '.$bot->channel_access_token
            ],
            'json' => []
        ]);
        $result = json_decode((string) $response->getBody(), true);

        $account->name = $result["displayName"];
        $account->setProperty("thumbnail", $result["pictureUrl"]);
        $account->save();

        return $account;
    } catch (\Exception $e) {
        \Log::error($e);
    }
    return null;
  }

  
  public function executeRequest(Bot $bot, $data){
    \Log::info( var_export($data,true) );
    if(!isset($data["events"][0]["type"])){
      \Log::error("Unexpected Format");
      return false;
    }
    switch ($data["events"][0]["type"]) {
      case 'follow':
        return $this->createAccount( $bot, $data );
      case 'unfollow':
        return $this->blockAccount( $bot, $data );
      case 'message':
        return $this->getMessage( $bot, $data );
      default:
        \Log::error("Unexpected Format");
        return false;
    }
  }

  public function createAccount(Bot $bot, $data){
    $userId = $data["events"][0]["source"]["userId"];

    $account = Account::firstOrCreate([
      "hash" => $userId,
      "bot_id" => $bot->id
    ]);

    $isNewAccount = $account->wasRecentlyCreated;

    $account->blocked_at = null;
    $account->reply_token = $data["events"][0]["replyToken"];
    $account->save();

    $account = $this->getProfile($bot, $account);

    $senario = $bot->checkApplicableSenario($account);
    if( $senario == null ){
      $account->senario_id = $senario->id;
      $account->save();
    }

    $senario->calcRules( $account, null );

    return true;
  }


  public function blockAccount(Bot $bot, $data){
    $userId = $data["events"][0]["source"]["userId"];

    $account = Account::where("hash", $userId)->where("bot_id", $bot->id)->firstOrFail();

    $account->blocked_at = now();
    $account->reply_token = null;
    $account->save();
    return true;
  }


  public function getMessage(Bot $bot, $data){

    $userId = $data["events"][0]["source"]["userId"];

    $account = Account::where("hash", $userId)->where("bot_id", $bot->id)->firstOrFail();

    $message = $account->messages()->create([
      "send_by" => Message::ACCOUNT,
      "body" => $data["events"][0]["message"]["text"],
      "message_token" => $data["events"][0]["message"]["id"],
      "reply_token" => $data["events"][0]["replyToken"]
    ]);
    $account->reply_token = $data["events"][0]["replyToken"];
    $account->save();


    if( $account->senario ){
      $account->senario->calcRules( $account, null );  
    }

    return true;
  }

}