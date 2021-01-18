<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationUser extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'organization_id', 'user_id', 'visible', 'verified', 'expired_at'
    ];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    	'expired_at' => 'datetime'
    ];

    /*
     * Get the organization associated with the membership
    */
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    /*
     * Get the user associated with the membership
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
