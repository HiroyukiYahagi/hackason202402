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
    const SET_PROPERTY = 3;

    /**
     * @var array
     */
    protected $fillable = ['senario_id', 'created_at', 'updated_at', 'deleted_at', 'condition', 'name', 'rule_type', 'priority', 'is_valid'];

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
}
