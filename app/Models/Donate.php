<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property string $name
 * @property Property[] $properties
 */
class Donate extends Model
{
    use SoftDeletes;

    protected $dates = ["deleted_at"];

    const TYPE_PAYJP = 0;
    /**
     * @var array
     */
    protected $fillable = ['created_at', 'updated_at', 'deleted_at', 'name', 'price', 'payment_token', 'payment_type', 'hash'];

    public static function validator(){
        return [
            "name" => "string",
            "hash" => "string",
            "price" => "numeric|nullable",
            "payment_token" => "string",
            "payment_type" => "numeric|nullable",
        ];
    }
}
