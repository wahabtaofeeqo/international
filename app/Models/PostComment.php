<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'message', 'user_id'
    ];

    /*
     * Get the post
    */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
