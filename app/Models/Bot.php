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

    protected $dates = ["deleted_at"];
    /**
     * @var array
     */
    protected $fillable = ['admin_id', 'created_at', 'updated_at', 'deleted_at', 'name', 'line_account_name', 'rich_menu', 'hash', 'channel_access_token', 'channel_secret', 'rich_menu_id', 'rich_menu_url', 'query_label'];

    public function getWebhookUrlAttribute(){
        return route('api.line.webhook', [
            "hash" => $this->hash
        ]);
    }
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
    public function activeAccounts()
    {
        return $this->hasMany('App\Models\Account')->whereNull("blocked_at");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function senarios()
    {
        return $this->hasMany('App\Models\Senario')->orderBy("priority", "asc");
    }

    public function validSenarios()
    {
        return $this->hasMany('App\Models\Senario')->where("is_valid", 1)->orderBy("priority", "asc");
    }

    public function checkApplicableSenario(Account $account){
        foreach( $this->validSenarios as $senario ){
            if( $senario->isApplicable($account) ) {
              return $senario;
            }
        }
        return null;
    }
}
