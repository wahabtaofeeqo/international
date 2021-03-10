<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'latitude', 'longitude', 'region_id', 'country_id'
    ];

    /*
     * Get the region associated with the city
    */
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function country() {
        return $this->belongsTo(Country::class);
    }

    /*
     * Get the users in the city
    */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /*
     * Get the organizations in the city
    */
    public function organizations()
    {
        return $this->hasMany(Organization::class);
    }
}
