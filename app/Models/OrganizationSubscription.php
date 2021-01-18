<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationSubscription extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'organization_id', 'email', 'language_id'
    ];

    /*
     * Get the organization associated with the subscription
    */
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    /*
     * Get the language associated with the subscription
    */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
