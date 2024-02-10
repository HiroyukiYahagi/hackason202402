<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Petition extends Model
{
    protected $fillable = ['created_at', 'updated_at', 'shop_id', 'desired_price', 'title', 'description', 'image_url'];

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
    public function affiliations()
    {
        return $this->hasMany('App\Models\Affiliation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function receipts()
    {
        return $this->hasMany('App\Models\Receipt');
    }

    public function getRestPriceAttribute(){
        $this->loadMissing(["receipts"]);
        return $this->usable_price - $this->receipts->sum("price");
    }

    public function getUsablePriceAttribute(){
        $this->loadMissing(["affiliations.results"]);
        $price = 0;
        foreach ($this->affiliations as $affiliation) {
            $price += $affiliation->results->sum("price");
        }
        return $price;
    }

}
