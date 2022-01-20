<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @property int $id
 * @property int $bot_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property string $rich_menu
 * @property string $condition
 * @property string $name
 * @property Bot $bot
 * @property Rule[] $rules
 */
class Senario extends Model
{
    use SoftDeletes;

    protected $dates = ["deleted_at"];
    /**
     * @var array
     */
    protected $fillable = ['bot_id', 'created_at', 'updated_at', 'deleted_at', 'rich_menu', 'condition', 'name', 'priority', 'is_valid', 'rich_menu_id', 'rich_menu_url', 'error_msg'];


    public function setConditionAttribute($value){
        // $value = str_replace("::", "", $value);
        // $value = str_replace("/", "", $value);
        $this->attributes['condition'] = $value;
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bot()
    {
        return $this->belongsTo('App\Models\Bot');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accounts()
    {
        return $this->hasMany('App\Models\Account');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rules()
    {
        return $this->hasMany('App\Models\Rule')->orderBy("priority", "asc");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function validRules()
    {
        return $this->hasMany('App\Models\Rule')->where("is_valid", 1)->orderBy("priority", "asc");
    }

    public function getIsValidLabelAttribute(){
        return $this->is_valid == 1 ? "有効": "無効";
    }

    public function isApplicable(Account $account){
        $account->load(["properties.label"]);
        \DB::beginTransaction();
        try{
            $result = eval($this->condition);
            \DB::rollBack();
            return $result;
        }catch(\Exception $e){
            \DB::rollBack();
            \Log::warn($e);
            return false;
        }
    }

    public function calcRules(Account $account, Message $message=null){
        if( $message == null ){
            $this->validRules()->where("rule_type", Rule::ADD_FRIEND)->get()->each(function( $rule ) use ( $account, $message ){
                if($rule->isApplicable( $account, $message )){
                    $rule->doActions( $account, $message );
                    $rule->increment("applied_count");
                }
            });
        }else{
            $account->lastBotMessage->action->rule->reactActions( $account, $message );

            $reply = false;
            $this->validRules()->where("rule_type", Rule::REPLY)->get()->each(function( $rule ) use ( $account, $message, &$reply ){
                if($rule->isApplicable( $account, $message )){
                    $rule->doActions( $account, $message );
                    $rule->increment("applied_count");
                    $reply = true;
                }
            });
            if( !$reply && $this->error_msg != null ){
                \DB::beginTransaction();
                try{
                    $correctBody = "\$json =<<<EOF\n{ \"messages\": ".$this->error_msg."}\nEOF;\nreturn \$json;";
                    $msg = eval($correctBody);
                    \DB::rollBack();

                    $messageData = $account->sendJsonMessage($msg);
                }catch(\Exception $e){
                    \DB::rollBack();
                    \Log::warn($e->getResponse()->getBody()->getContents());
                }
            }
        }
    }

    public function copy(){
        $newSenario = Senario::create([
          "name" => explode("_", $this->name)[0]."_".now()->format("Ymdhis"),
          "bot_id" => $this->bot_id,
          "priority" => $this->priority,
          "is_valid" => 0,
          "condition" => $this->condition,
          "rich_menu" => $this->rich_menu
        ]);
        $this->rules->each( function($rule) use ($newSenario) {
            $rule = $rule->copy();
            $rule->senario_id = $newSenario->id;
            $rule->save();
        });
        return $newSenario;
    }
}
