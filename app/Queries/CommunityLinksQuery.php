<?php
/**
 * This is a dedicated class to perform query to fetch the community links
 */

namespace App\Queries;

use App\CommunityLink;

class CommunityLinksQuery {

    public function get($sortByPopular, $channel)
    {
        // If we have popular key (any values included) in the query string (url), order it by vote_count else order it by update at
        // Laravel use the withCount "votes" & append "_count" so the sortByPopular becomes "votes_count"
        $orderBy = $sortByPopular ? 'votes_count' : 'updated_at';

        // Eager load the relationship on votes, creator & channel
        // Order by vote count desc
        return CommunityLink::with('creator', 'channel')
            ->withCount('votes') // Count the number of votes that's associated with the community link
            ->forChannel($channel)
            ->orderBy($orderBy, 'desc')
            ->paginate(4);
    }
}