<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    /**
     * @var array
     */
    protected $fillable = ['bot_id', 'created_at', 'updated_at', 'deleted_at', 'rich_menu', 'condition', 'name'];

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
    public function rules()
    {
        return $this->hasMany('App\Models\Rule');
    }
}
