<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property string $email
 * @property string $password
 * @property Bot[] $bots
 */
class Admin extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['created_at', 'updated_at', 'deleted_at', 'email', 'password'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bots()
    {
        return $this->hasMany('App\Models\Bot');
    }
}
