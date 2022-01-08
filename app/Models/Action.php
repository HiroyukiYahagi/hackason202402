<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @property int $id
 * @property int $rule_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property string $body
 * @property int $order
 * @property string $name
 * @property Rule $rule
 * @property Message[] $messages
 */
class Action extends Model
{
    use SoftDeletes;

    const SEND_MESSAGE = 1;
    const ADD_PROPERTY = 2;
    const OTHER = 0;

    protected $dates = ["deleted_at"];
    /**
     * @var array
     */
    protected $fillable = ['rule_id', 'created_at', 'updated_at', 'deleted_at', 'body', 'order', 'name', 'action_type', 'is_after'];

    public function setBodyAttribute($value){
        // $value = str_replace("::", "", $value);
        // $value = str_replace("/", "", $value);
        $this->attributes['body'] = $value;
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rule()
    {
        return $this->belongsTo('App\Models\Rule');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany('App\Models\Message');
    }

    public function do(Account $account, Message $message=null){
        $account->load(["properties.label"]);

        switch( $this->action_type ){
        case $this::SEND_MESSAGE:
            \DB::beginTransaction();
            $message = null;
            try{
                $correctBody = "\$json =<<<EOF\n{ \"messages\": ".$this->body."}\nEOF;\nreturn \$json;";
                $message = eval($correctBody);
                \DB::rollBack();

                $messageData = $account->sendJsonMessage($message);
                if( $messageData != null ){
                    $this->messages()->create([
                        "account_id" => $account->id,
                        "message_token" => $messageData["token"],
                        "body" => json_encode($messageData["messages"],JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT),
                        "send_by" => Message::BOT
                    ]);
                }
                return true;
            }catch(\Exception $e){
                \DB::rollBack();
                \Log::warn($e->getResponse()->getBody()->getContents());
                $this->rule->increment("error_count");
                return false;
            }
            break;
        case $this::ADD_PROPERTY:
            \DB::beginTransaction();
            try{
                $correctBody = "\$json =<<<EOF\n".$this->body."\nEOF;\nreturn \$json;";
                $property = eval($correctBody);
                $property = json_decode($property, true);

                $account->setProperty($property["key"], $property["value"], isset($property["singleton"]) ? $property["singleton"] : true);
                \DB::commit();
                return true;
            }catch(\Exception $e){
                \DB::rollBack();
                \Log::warn($e);
                $this->rule->increment("error_count");
                return false;
            }
            break;
        default:
            \DB::beginTransaction();
            try{
                $result = eval($this->body);
                \DB::commit();
                return true;
            }catch(\Exception $e){
                \DB::rollBack();
                \Log::warn($e);
                $this->rule->increment("error_count");
                return false;
            }
            break;
        }
    }

    public function copy(){
        $newAction = Action::create([
          "name" => $this->name,
          "body" => $this->body,
          "action_type" => $this->action_type,
          "is_after" => $this->is_after,
          "order" => $this->order,
        ]);
        return $newAction;
    }
}
