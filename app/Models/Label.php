<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property string $name
 * @property Property[] $properties
 */
class Label extends Model
{
    use SoftDeletes;

    protected $dates = ["deleted_at"];
    /**
     * @var array
     */
    protected $fillable = ['created_at', 'updated_at', 'deleted_at', 'name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function properties()
    {
        return $this->hasMany('App\Models\Property');
    }
}
