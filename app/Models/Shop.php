<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

class Shop extends Authenticatable
{
    protected $fillable = ['created_at', 'updated_at', 'email', 'shop_name', 'password', 'hash', 'bank_name', 'bank_branch', 'bank_number', 'bank_type', 'homepage_url', 'image_url', 'description'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function petitions()
    {
        return $this->hasMany('App\Models\Petition');
    }

}
