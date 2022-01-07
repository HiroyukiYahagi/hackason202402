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

    protected $dates = ["deleted_at"];
    /**
     * @var array
     */
    protected $fillable = ['rule_id', 'created_at', 'updated_at', 'deleted_at', 'body', 'order', 'name'];

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
}
