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
    protected $fillable = ['bot_id', 'created_at', 'updated_at', 'deleted_at', 'rich_menu', 'condition', 'name', 'priority', 'is_valid'];


    public function setConditionAttribute($value){
        $value = str_replace("::", "", $value);
        $value = str_replace("/", "", $value);
        $value = str_replace("\\", "", $value);
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

    public function isApplicable(Account $account){
        $account->load(["properties.label"]);
        \DB::beginTransaction();
        try{
            $result = eval($this->condition);
            \DB::rollBack();
            return $result;
        }catch(\Exception $e){
            \DB::rollBack();
            return false;
        }
    }

    public function calcRules(Account $account, Message $message=null){
        if( $message == null ){
            $this->validRules()->where("rule_type", Rule::ADD_FRIEND)->get()->each(function( $rule ) use ( $account, $message ){
                if($rule->isApplicable( $account, $message )){
                    $rule->doActions( $account, $message );
                }
            });
        }else{
            $this->validRules()->where("rule_type", Rule::REPLY)->get()->each(function( $rule ) use ( $account, $message ){
                if($rule->isApplicable( $account, $message )){
                    $rule->doActions( $account, $message );
                }
            });
        }
    }
}
