<?php

namespace App\Http\Controllers;

use App\Channel;
use App\CommunityLink;
use Illuminate\Http\Request;
use App\Queries\CommunityLinksQuery;
use App\Http\Requests\CommunityLinkForm;
use App\Exceptions\CommunityLinkAlreadySubmitted;

// use App\Http\Requests;

/**
 * Show all community links
 *
 * @param  $Channel $channel
 * @return \Illuminate\View\View
 */
class CommunityLinksController extends Controller
{
    public function index(Channel $channel = null)
    {
        $links = (new CommunityLinksQuery)->get(
            request()->exists('popular'), $channel
        );

        $channels = Channel::orderBy('title', 'asc')->get();

    	return view('community.index', compact('links', 'channels', 'channel'));
    }

    public function store(CommunityLinkForm $request)
    {
        /* This validation was moved on App\Http\Requests\CommunityLinkForm.php */
        // $this->validate($request, [
        //     'channel_id' => 'required|exists:channels,id', // Channel ID should exist in the channels table with the column on ID
        //     'title' => 'required',
        //     'link' => 'required|active_url' // |unique:community_links
        // ]);

        try {
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
        } catch (CommunityLinkAlreadySubmitted $e) {
            flash()->overlay("We'll instead bump the timestamps and bring that back to the top. Thanks!", 'That link has already been submitted');
        }

    	return back();
    }
}
