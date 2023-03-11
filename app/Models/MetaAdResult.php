<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MetaAdResult extends Model
{
    
    protected $connection = 'coco_db';

    protected $dates = ["target_at"];
    /**
     * @var array
     */
    protected $fillable = [
        'created_at', 'updated_at', 'partner_name', 'media_name', 'campaign_name', 'adset_name', 'ad_name', 'placement', 'campaign_id', 'adset_id', 'ad_id', 'target_at', "full_link", "link_url", "dump", 'cost', 'impression', 'frequency', 'click', 'conversion', 

        "utm_source", "utm_medium", "utm_campaign", "utm_content", "utm_term",

        "ad_text", "ad_image",
    ];

}
