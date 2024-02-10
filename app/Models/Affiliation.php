<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Affiliation extends Model
{
    protected $fillable = ['created_at', 'updated_at', 'thema_id', 'petition_id', 'price'];

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
    public function petition()
    {
        return $this->belongsTo('App\Models\Petition');
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
