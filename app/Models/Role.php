<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /*
	 * Get the users associated with the city
    */
    public function users()
    {
    	return $this->hasMany(User::class);
    }
}
