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
    /**
     * @var array
     */
    protected $fillable = ['bot_id', 'created_at', 'updated_at', 'deleted_at', 'rich_menu', 'condition', 'name', 'priority', 'is_valid'];

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

    public function checkApplicable(Account $account){
        $account->load(["properties.label"]);
        return eval($this->condition);
    }
}
