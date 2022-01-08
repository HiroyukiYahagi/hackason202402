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


    protected $dates = ["deleted_at", "blocked_at", "token_updated_at"];

    /**
     * @var array
     */
    protected $fillable = ['bot_id', 'senario_id', 'created_at', 'updated_at', 'deleted_at', 'hash', 'name', 'reply_token', 'blocked_at', "token_updated_at"];

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

    public function sendTextMessage($message){
        $json = [
            ["type" => "text","text" => $message]
        ];
        return $this->sendMessage($json);
    }

    public function sendMessage($json){

        $messageData = [
            "messages" => $json,
            "to" => $this->hash,
            "token" => null
        ];
        $url = "https://api.line.me/v2/bot/message/push";
        if( $this->reply_token != null && $this->token_updated_at >= now()->subHour(1) ){
            if( $this->messages()->where("message_token")->count() != null ){
                // tokenが使われていなけれ
                $url = "https://api.line.me/v2/bot/message/reply";
                $messageData["replyToken"] = $this->reply_token;
                $messageData["token"] = $this->reply_token;
            }
        }

        try {
            $client = new RequestClient();
            $response = $client->post($url, [
                'debug' => true,
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
            $this->properties()->create([
                "label_id" => $label->id,
                "val" => $value
            ]);
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
}
