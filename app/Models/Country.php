<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone_index'
    ];

    /*
	 * Get the regions associated with the country
    */
    public function regions() {
    	return $this->hasMany(Region::class);
    }

    /*
	 * Get the cities associated with the organization
    */
    public function cities() {
    	return $this->hasManyThrough(City::class, Region::class);
    }

    public function city() {
        return $this->hasMany(City::class);
    }
}
