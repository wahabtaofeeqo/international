<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'birth_year', 'gender', 'phone_number', 'password', 'photo', 'subscribed', 'language_id', 'city_id', 'organization_id', 'role_id', 'projects',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*
     * Know which gender user is
    */
    public function getNamedGenderAttribute()
    {
        if ($this->gender == 1) {
            return 'M';
        } else {
            return 'F';
        }
    }

    /*
     * Get the role of the user
    */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /*
     * Get the posts that the user is associated with
    */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /*
     * Get the organization that the user is associated with
    */
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    /*
     * Get the membership of the user
    */
    public function membership()
    {
        return $this->hasOne(OrganizationUser::class);
    }

    /*
     * Get the users associated with the city
    */
    public function socialProfile()
    {
        return $this->hasOne(UserSocial::class);
    }

    /*
     * Get the user's city
    */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /*
     * Get the user's language
    */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    /*
     * Check if user's role is 'user'
    */
    public function isUser()
    {
        if ($this->role->name != 'user') {
            return false;
        }

        return true;
    }

    /*
     * Check if user's role is 'editor'
    */
    public function isEditor()
    {
        if ($this->role->name != 'editor') {
            return false;
        }

        return true;
    }

    /*
     * Check if user's role is 'admin'
    */
    public function isAdmin()
    {
        if ($this->role->name != 'admin') {
            return false;
        }

        return true;
    }

    /*
     * Check if user's role is 'super'
    */
    public function isSuper()
    {
        if ($this->role->name != 'super') {
            return false;
        }

        return true;
    }
}
