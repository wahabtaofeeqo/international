<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subject', 'content', 'target', 'organization_id'
    ];

    /*
     * Get the organization associated with the newsletter
    */
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
