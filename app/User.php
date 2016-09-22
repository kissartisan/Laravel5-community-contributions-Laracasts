<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isTrusted()
    {
        return !! $this->trusted; // Typecast to boolean
    }


    public function votes() // $user->votes
    {
        // If many to many relationship, we will use the pivot table name
        return $this->belongsToMany(CommunityLink::class, 'community_links_votes')
                ->withTimestamps();
    }

    public function toggleVoteFor(CommunityLink $link)
    {
        // Give the first one that matches the database
        // Then toggle it true or false
        CommunityLinkVote::firstOrNew([
            'user_id' => $this->id,
            'community_link_id' => $link->id
        ])->toggle();
    }


    // public function voteFor(CommunityLink $link)
    // {
    //     // return $this->votes()->attach($link);

    //     // You will not attach the same records twice
    //     return $this->votes()->sync([$link->id], false);
    // }

    // public function unvoteFor(CommunityLink $link)
    // {
    //     return $this->votes()->detach($link);
    // }

    /**
     * If the collection ($link->votes) contains an item
     * where the user_id with in it is equal to the current
     * user logged in
     * @param  CommunityLink $link [description]
     * @return [type]              [description]
     */
    public function votedFor(CommunityLink $link)
    {
        return $link->votes->contains('user_id', $this->id);
    }
}
