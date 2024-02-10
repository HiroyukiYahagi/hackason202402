<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Vote extends Model
{
    protected $dates = [ 'deadline_at' ];

    protected $fillable = ['created_at', 'updated_at', 'user_id', 'receipt_id', 'deadline_at', 'status', 'message'];

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
    public function receipt()
    {
        return $this->belongsTo('App\Models\Receipt');
    }

}
