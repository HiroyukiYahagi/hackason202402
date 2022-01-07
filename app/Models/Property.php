<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @property int $id
 * @property int $account_id
 * @property int $label_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property string $val
 * @property Account $account
 * @property Label $label
 */
class Property extends Model
{
    use SoftDeletes;

    protected $dates = ["deleted_at"];
    /**
     * @var array
     */
    protected $fillable = ['account_id', 'label_id', 'created_at', 'updated_at', 'deleted_at', 'val'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo('App\Models\Account');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function label()
    {
        return $this->belongsTo('App\Models\Label');
    }
}
