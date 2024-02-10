<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Receipt extends Model
{
    protected $dates = [ 'deadline_at' ];

    protected $fillable = ['created_at', 'updated_at', 'petition_id', 'description', 'image_url', 'price', 'status'];

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
    public function votes()
    {
        return $this->hasMany('App\Models\Vote');
    }

    public function getImageAttribute(){
        return \Storage::url( $this->image_url );
    }
}
