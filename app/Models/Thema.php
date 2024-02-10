<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Thema extends Model
{
    protected $fillable = ['created_at', 'updated_at', 'title', 'image_url', 'keywords'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function usecases()
    {
        return $this->hasMany('App\Models\Usecase');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function affiliations()
    {
        return $this->hasMany('App\Models\Affiliation');
    }
}
