<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slogan', 'logo', 'description', 'address', 'city_id'
    ];

    /*
	 * Get the users associated with the organization
    */
    public function users()
    {
    	return $this->hasMany(User::class);
    }

    /*
	 * Get the users associated with the organization
    */
    public function members()
    {
    	return $this->hasMany(OrganizationUser::class);
    }

    /*
     * Get the newsletters associated with the organization
    */
    public function newsletters()
    {
        return $this->hasMany(Newsletter::class);
    }

    /*
     * Get the blog posts associated with the organization
    */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /*
     * Get the city associated with the organization
    */
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
