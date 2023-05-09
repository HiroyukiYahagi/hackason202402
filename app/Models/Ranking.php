<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @property int $id
 * @property int $account_id
 * @property int $label_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property string $val
 * @property Account $account
 * @property Label $label
 */
class Ranking extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['created_at', 'updated_at', 'name', 'registered_cnt', 'queried_cnt'];
}
