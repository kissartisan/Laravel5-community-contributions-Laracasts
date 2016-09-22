<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $fillable = ['title', 'slug', 'color'];


    // Use a slug for the route key instead of an id
    // getRouteKeyName is an existing method on your Eloquent model
    public function getRouteKeyName()
    {
        return 'slug'; // Return a slug instead of an id in the URL
    }
}
