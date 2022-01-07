<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property string $path
 */
class Asset extends Model
{
    use SoftDeletes;

    protected $dates = ["deleted_at"];
    /**
     * @var array
     */
    protected $fillable = ['created_at', 'updated_at', 'deleted_at', 'path'];

    public function getFullUrlAttribute(){
        return \Storage::url($this->path);
    }
}
