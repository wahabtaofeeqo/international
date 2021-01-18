<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'content', 'featured_image', 'likes', 'status', 'verified', 'user_id', 'organization_id'
    ];

    /*
     * Get the owner of the post
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
     * Get the owner (organization) of the post
    */
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    /*
     * Get the comments of the post
    */
    public function comments()
    {
        return $this->hasMany(PostComment::class);
    }
}
