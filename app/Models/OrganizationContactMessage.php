<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationContactMessage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'organization_id', 'name', 'email', 'subject', 'message'
    ];

    /*
     * Get the organization associated with the contact message
    */
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
