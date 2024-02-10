<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Usecase extends Model
{
    protected $fillable = ['created_at', 'updated_at', 'title', 'description', 'thema_id', 'donate_id', 'price'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function donate()
    {
        return $this->belongsTo('App\Models\Donate');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function thema()
    {
        return $this->belongsTo('App\Models\Thema');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function results()
    {
        return $this->hasMany('App\Models\Result');
    }

    public function getRestPriceAttribute(){
        $this->loadMissing(["results"]);
        return $this->price - $this->results->sum("price");
    }

    public function getUsePriceAttribute(){
        $this->loadMissing(["results"]);
        return $this->results->sum("price");
    }

}
