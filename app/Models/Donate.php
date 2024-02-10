<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Donate extends Model
{
    protected $fillable = ['created_at', 'updated_at', 'user_id', 'shop_id', 'payjp_token', 'price', 'title', 'description'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shop()
    {
        return $this->belongsTo('App\Models\Shop');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function usecases()
    {
        return $this->HasMany('App\Models\Usecase');
    }


}
