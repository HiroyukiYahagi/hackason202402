<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Result extends Model
{
    protected $fillable = ['created_at', 'updated_at', 'usecase_id', 'affiliation_id', 'price', 'status'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function usecase()
    {
        return $this->belongsTo('App\Models\Usecase');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function affiliation()
    {
        return $this->belongsTo('App\Models\Affiliation');
    }
}
