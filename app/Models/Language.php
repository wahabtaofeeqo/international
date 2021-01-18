<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'code',
    ];

    /*
     * Get the users that speak the language
    */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /*
     * Get the subscribers that speak the language
    */
    public function subscribers()
    {
        return $this->hasMany(OrganizationSubscription::class);
    }

    /*
     * Get the organization users that speak the language
    */
    public function organizationUsers()
    {
        return $this->hasManyThrough(OrganizationUser::class, User::class);
    }
}
