<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @property int $id
 * @property int $account_id
 * @property int $action_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property string $body
 * @property int $send_by
 * @property string $message_token
 * @property string $reply_token
 * @property Account $account
 * @property Action $action
 */
class Message extends Model
{
    use SoftDeletes;
    /**
     * @var array
     */
    protected $fillable = ['account_id', 'action_id', 'created_at', 'updated_at', 'deleted_at', 'body', 'send_by', 'message_token', 'reply_token'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo('App\Models\Account');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function action()
    {
        return $this->belongsTo('App\Models\Action');
    }
}
