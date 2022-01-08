<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @property int $id
 * @property int $senario_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property string $condition
 * @property string $name
 * @property int $rule_type
 * @property Senario $senario
 * @property Action[] $actions
 */
class Rule extends Model
{
    use SoftDeletes;


    const ADD_FRIEND = 1;
    const REPLY = 2;
    const HOURLY = 3;

    protected $dates = ["deleted_at"];

    /**
     * @var array
     */
    protected $fillable = ['senario_id', 'created_at', 'updated_at', 'deleted_at', 'condition', 'name', 'rule_type', 'priority', 'is_valid', 'applied_count', 'error_count', 'blocked_count'];

    public function setConditionAttribute($value){
        // $value = str_replace("::", "", $value);
        // $value = str_replace("/", "", $value);
        $this->attributes['condition'] = $value;
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
    public function actions()
    {
        return $this->hasMany('App\Models\Action');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function beforeActions()
    {
        return $this->hasMany('App\Models\Action')->where("is_after", 0);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function afterActions()
    {
        return $this->hasMany('App\Models\Action')->where("is_after", 1);
    }

    public function getIsValidLabelAttribute(){
        return $this->is_valid == 1 ? "有効": "無効";
    }

    public function isApplicable(Account $account, Message $message=null){
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

    public function doActions(Account $account, Message $message=null){
        $this->beforeActions->each(function($action) use ($account, $message){
            $action->do( $account, $message );
        });
    }

    public function reactActions(Account $account, Message $message=null){
        $this->afterActions->each(function($action) use ($account, $message){
            $action->do( $account, $message );
        });
    }

    public function copy(){
        $newRule = Rule::create([
          "name" => $this->name,
          "condition" => $this->condition,
          "rule_type" => $this->rule_type,
          "priority" => $this->priority,
          "is_valid" => $this->is_valid,
        ]);
        $this->actions->each( function($action) use ($newRule) {
            $action = $action->copy();
            $action->rule_id = $newRule->id;
            $action->save();
        });
        return $newRule;
    }
}
