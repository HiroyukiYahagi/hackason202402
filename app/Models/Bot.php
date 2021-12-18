<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @property int $id
 * @property int $admin_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property string $name
 * @property string $line_account_name
 * @property string $rich_menu
 * @property Admin $admin
 * @property Account[] $accounts
 * @property Senario[] $senarios
 */
class Bot extends Model
{
    use SoftDeletes;
    /**
     * @var array
     */
    protected $fillable = ['admin_id', 'created_at', 'updated_at', 'deleted_at', 'name', 'line_account_name', 'rich_menu', 'hash'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin()
    {
        return $this->belongsTo('App\Models\Admin');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accounts()
    {
        return $this->hasMany('App\Models\Account');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function senarios()
    {
        return $this->hasMany('App\Models\Senario');
    }
}
