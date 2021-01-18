<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'country_id',
    ];

    /*
     * Get the country of the region
    */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /*
     * Get the cities associated with the region
    */
    public function cities()
    {
        return $this->hasMany(City::class);
    }

    /*
     * Get the users associated with the region through its cities
    */
    public function users()
    {
        return $this->hasManyThrough(User::class, City::class);
    }

    /*
     * Get the organizations associated with the region through its cities
    */
    public function organizations()
    {
        return $this->hasManyThrough(Organization::class, City::class);
    }
}
