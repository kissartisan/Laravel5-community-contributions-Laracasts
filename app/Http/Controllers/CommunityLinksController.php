<?php

namespace App\Http\Controllers;

use App\CommunityLink;
use App\Channel;
use Illuminate\Http\Request;

// use App\Http\Requests;

class CommunityLinksController extends Controller
{
    public function index()
    {
    	$links = CommunityLink::where('approved', 1)->paginate(25);
        $channels = Channel::orderBy('title', 'asc')->get();

        // flash('Testing testing', 'danger')->important();
    	
    	return view('community.index', compact('links'), compact('channels'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'channel_id' => 'required|exists:channels,id', // Channel ID should exist in the channels table with the column on ID
            'title' => 'required',
            'link' => 'required|active_url|unique:community_links'
        ]);

    	// Add a setter came from the Model
    	CommunityLink::from(auth()->user())
    		->contribute($request->all());

        if (auth()->user()->isTrusted()) {
            flash('Thanks for the contribution!', 'success');
            /* OR */
            flash()->success('Thanks for the contribution');
        } else {
            flash()->overlay('Thanks', 'This contribution will be approved shortly');
        }

    	return back();
    }
}
