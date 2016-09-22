<?php

namespace App\Http\Controllers;

use App\CommunityLink;
use App\Http\Requests;
use App\CommunityLinkVote;
use Illuminate\Http\Request;

class VotesController extends Controller
{
    public function __construct()
    {
        // Add a middleware that:
        // You need to sign in in order to click the like button
        $this->middleware('auth');
    }

    public function store(CommunityLink $link)
    {
        auth()->user()->toggleVoteFor($link);

        return back();
    }
}
