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
    $account->activated_at = now();
    $account->reply_token = $data["events"][0]["replyToken"];
    $account->token_updated_at = now();
    $account->save();

    $account = $this->getProfile($bot, $account);

    $senario = $bot->checkApplicableSenario($account);
    if( $senario != null ){
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

    $account->lastBotMessage->action->rule->increment("blocked_count");

    return true;
  }


  public function getMessage(Bot $bot, $data){

    $userId = $data["events"][0]["source"]["userId"];

    $account = Account::where("hash", $userId)->where("bot_id", $bot->id)->firstOrFail();

    if( $data["events"][0]["message"]["type"] != 'text' ){
      return false;
    }

    $message = $account->messages()->create([
      "send_by" => Message::ACCOUNT,
      "type" => $data["events"][0]["message"]["type"],
      "text" => $data["events"][0]["message"]["text"],
      "body" => json_encode($data["events"][0]["message"],JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT),
      "message_token" => $data["events"][0]["message"]["id"],
      "reply_token" => $data["events"][0]["replyToken"]
    ]);
    $account->reply_token = $data["events"][0]["replyToken"];
    $account->token_updated_at = now();
    $account->save();


    if( $account->senario ){
      $account->senario->calcRules( $account, $message );  
    }

    return true;
  }

  public function setRichMenu(Bot $bot, $richMenu, $richMenuUrl, $isDefault=false){

    try {
        $client = new RequestClient();
        $response = $client->post("https://api.line.me/v2/bot/richmenu", [
            'debug' => true,
            'headers' => [
              'Authorization' => 'Bearer '.$bot->channel_access_token
            ],
            'json' => json_decode($richMenu, true)
        ]);
        $result = json_decode((string) $response->getBody(), true);


        $contentType = strpos($richMenuUrl, ".png") !== false ? 'image/png': 'image/jpeg';
        if(strpos($richMenuUrl, \Storage::url("")) !== false){
          $absPath = explode( \Storage::url(""), $richMenuUrl)[1];
          $richMenuUrl = \Storage::path($absPath);
        }

        $output=null;
        $retval=null;

        exec('curl -v -X POST https://api-data.line.me/v2/bot/richmenu/'.$result["richMenuId"].'/content -H "Authorization: Bearer '.$bot->channel_access_token.'" -H "Content-Type: '.$contentType.'" -T '.$richMenuUrl, $output, $retval);
        \Log::info($output);
        \Log::info($retval);

        if( $isDefault ){
          $response = $client->post("https://api.line.me/v2/bot/user/all/richmenu/".$result["richMenuId"], [
              'debug' => true,
              'headers' => [
                'Authorization' => 'Bearer '.$bot->channel_access_token
              ]
          ]);
          json_decode((string) $response->getBody(), true);
        }

        return $result["richMenuId"];
    } catch (\Exception $e) {
        \Log::error($e);
        return null;
    }
    
  }

}