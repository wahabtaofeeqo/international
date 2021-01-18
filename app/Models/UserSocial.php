<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSocial extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'skype', 'facebook', 'twitter', 'discord', 'slack', 'whatsapp', 'linkedin', 'user_id'
    ];

    /*
	 * Get the user that owns the social links
    */
    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
