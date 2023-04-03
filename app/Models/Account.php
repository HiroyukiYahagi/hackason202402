<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use GuzzleHttp\Client as RequestClient;
/**
 * @property int $id
 * @property int $bot_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property string $hash
 * @property string $name
 * @property string $reply_token
 * @property string $blocked_at
 * @property Bot $bot
 * @property Message[] $messages
 * @property Property[] $properties
 */
class Account extends Model
{
    use SoftDeletes;


    protected $dates = ["deleted_at", "blocked_at", "token_updated_at", "activated_at"];

    /**
     * @var array
     */
    protected $fillable = ['bot_id', 'senario_id', 'created_at', 'updated_at', 'deleted_at', 'hash', 'name', 'reply_token', 'blocked_at', "token_updated_at", "activated_at", 'query_label'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bot()
    {
        return $this->belongsTo('App\Models\Bot');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function senario()
    {
        return $this->belongsTo('App\Models\Senario');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany('App\Models\Message');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function properties()
    {
        return $this->hasMany('App\Models\Property');
    }

    public function tap( $input ){
        return $input;
    }

    public function lastBotMessage(){
        return $this->hasOne('App\Models\Message')->where("send_by", Message::BOT)->orderBy("created_at", "desc");
    }

    public function getPetNamesAttribute(){
        $pet_names = $this->getProperty("pet_names");
        if( $pet_names->count() == 0 ) {
            return $this->name."さんのワンちゃん";
        }else{
            return $pet_names->map(function($name) {
                return str_replace( ["ちゃん", "くん", "君"], "", $name);
            })->implode("ちゃん・")."ちゃん";
        }
    }

    public function sendTextMessage($message){
        $messages = [
            ["type" => "text","text" => $message]
        ];
        return $this->sendMessage($messages);
    }

    public function sendJsonMessage($json){
        \Log::info($json);
        $json = json_decode($json, true);
        \Log::info($json);
        return $this->sendMessage($json["messages"]);
    }

    public function sendMessage($messages){
        $messageData = [
            "messages" => $messages,
            "to" => $this->hash,
            "token" => null
        ];
        $url = "https://api.line.me/v2/bot/message/push";
        if( $this->reply_token != null && $this->token_updated_at >= now()->subHour(1) ){
            if( $this->messages()->where("message_token", $this->reply_token)->count() == 0 ){
                // tokenが使われていなけれ
                $url = "https://api.line.me/v2/bot/message/reply";
                $messageData["replyToken"] = $this->reply_token;
                $messageData["token"] = $this->reply_token;
            }
        }

        try {
            $client = new RequestClient();
            $response = $client->post($url, [
                // 'debug' => true,
                'headers' => [
                  'Authorization' => 'Bearer '.$this->bot->channel_access_token
                ],
                'json' => $messageData
            ]);
            $result = json_decode((string) $response->getBody(), true);
            return $messageData;
        } catch (\Exception $e) {
            \Log::error($e);
            return null;
        }
    }

    public function getPropertyTableAttribute(){
        $this->load(["properties.label"]);
        return $this->properties->mapToGroups(function( $property ){
            return [ $property->label->name => $property->val ];
        })->map(function($data, $key){
            return [ "key" => $key, "data" => $data ];
        })->values();
    }

    public function setPropertyTableAttribute($table){
        $this->properties()->delete();
        foreach( $table as $row ){
            foreach( $row["data"] as $data ){
                $this->setProperty( $row["key"], $data, false );
            }
        }
    }

    public function getProperty($key){
        return $this->properties->filter( function($property) use ($key){
            return $property->label->name == $key;
        })->map(function($property){
            return $property->val;
        });
    }

    public function setProperty($key, $value, $singleton=true){
        $label = Label::firstOrCreate([
            "name" => $key
        ]);
        if( $singleton ){
            $this->properties()->where("label_id", $label->id)->delete();
        }
        if( is_array($value) ){
            foreach( $value as $v ){
                $this->properties()->firstOrCreate([
                    "label_id" => $label->id,
                    "val" => $v
                ]);
            }
        }else{
            $this->properties()->firstOrCreate([
                "label_id" => $label->id,
                "val" => $value
            ]);
        }
    }

    public function removeProperty($key, $value=null){
        $label = Label::firstOrCreate([
            "name" => $key
        ]);
        if( $value == null ){
            $this->properties()->where("label_id", $label->id)->delete();
        }else{
            $this->properties()->where("label_id", $label->id)->where("val", $value)->delete();
        }
    }

    public function dayAfterActivated($day){
        $target = $this->activated_at->copy();
        if( $target->hour < 2 ){
            $target->setHour(23);
        }else if( $target->hour < 7 ){
            $target->setHour(7);
        }
        $now = now()->subDay($day)->startOfHour();
        return $target >= $now && $target < $now->addHour(1);
    }

    public function dayAfterCreated($day){
        $target = $this->created_at->copy();
        if( $target->hour < 2 ){
            $target->setHour(23);
        }else if( $target->hour < 7 ){
            $target->setHour(7);
        }
        $now = now()->subDay($day)->startOfHour();
        return $target >= $now && $target < $now->addHour(1);
    }

    public function dayWithActivatedHour($day){
        if( $day != now()->format("Y-m-d") ){
            return false;
        }
        $target = $this->created_at->copy();
        if( $target->hour < 2 ){
            $target->setHour(23);
        }else if( $target->hour < 7 ){
            $target->setHour(7);
        }
        $now = now()->startOfHour();
        return $target->hour == $now->hour;
    }

    public function getQueryParamsAttribute(){
        return "&utm_source=line&utm_medium=social&utm_campaign=bot_".$this->bot->query_label."&utm_content=".$this->senario->query_label."&code=".$this->senario->query_label."&bot_account_id=".$this->id;
    }
}
