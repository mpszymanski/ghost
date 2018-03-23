<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
	public $fillable = ['event_id', 'user_id', 'is_confirmed', 'invited_by'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
