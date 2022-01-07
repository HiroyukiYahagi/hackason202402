<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @property int $id
 * @property int $bot_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property string $hash
 * @property string $name
 * @property string $reply_token
 * @property string $blocked_at
 * @property Bot $bot
 * @property Message[] $messages
 * @property Property[] $properties
 */
class Account extends Model
{
    use SoftDeletes;


    protected $dates = ["deleted_at", "blocked_at"];

    /**
     * @var array
     */
    protected $fillable = ['bot_id', 'senario_id', 'created_at', 'updated_at', 'deleted_at', 'hash', 'name', 'reply_token', 'blocked_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bot()
    {
        return $this->belongsTo('App\Models\Bot');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function senario()
    {
        return $this->belongsTo('App\Models\Senario');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany('App\Models\Message');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function properties()
    {
        return $this->hasMany('App\Models\Property');
    }

    public function getPropertyTableAttribute(){
        $this->load(["properties.label"]);
        return $this->properties->mapToGroups(function( $property ){
            return [ $property->label->name => $property->val ];
        })->map(function($data, $key){
            return [ "key" => $key, "data" => $data ];
        })->values();
    }

    public function setPropertyTableAttribute($table){
        $this->properties()->delete();
        foreach( $table as $row ){
            foreach( $row["data"] as $data ){
                $this->setProperty( $row["key"], $data, false );
            }
        }
    }

    public function setProperty($key, $value, $singleton=true){
        $label = Label::firstOrCreate([
            "name" => $key
        ]);
        if( $singleton ){
            $this->properties()->where("label_id", $label->id)->delete();
            $this->properties()->create([
                "label_id" => $label->id,
                "val" => $value
            ]);
        }else{
            $this->properties()->firstOrCreate([
                "label_id" => $label->id,
                "val" => $value
            ]);
        }
    }

    public function removeProperty($key, $value=null){
        $label = Label::firstOrCreate([
            "name" => $key
        ]);
        if( $value == null ){
            $this->properties()->where("label_id", $label->id)->delete();
        }else{
            $this->properties()->where("label_id", $label->id)->where("val", $value)->delete();
        }
    }
}
