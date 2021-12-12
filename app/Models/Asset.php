<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property string $path
 */
class Asset extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['created_at', 'updated_at', 'deleted_at', 'path'];

}
