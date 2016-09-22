<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\CommunityLinkAlreadySubmitted;

class CommunityLink extends Model
{
	protected $fillable = ['channel_id', 'title', 'link'];

    public static function from(User $user)
    {
        $link = new static;

        $link->user_id = $user->id;

        if ($user->isTrusted()) {
            $link->approve();
        }

        return $link;
    }

    // Mark the community link as approved
    /**
     * Contribute the given community link
     * @param  array $attributes
     * @return bool
     */
    public function contribute($attributes)
    {
        if ($existing = $this->hasAlreadyBeenSubmitted($attributes['link'])) {
            $existing->touch(); // Renew the timestamps

            // Throw an exception
            throw new CommunityLinkAlreadySubmitted;
        }

    	return $this->fill($attributes)->save();
    }

    /**
     * Scope the query to recods from a particular channel
     * @param  Builder $builder
     * @param  Channel $channel
     * @return Builder
     * Good morning po Ma'am. Pwede po magpatulong mag manhours? First time ko po kasi mag estimate ng timespan sa pag gawa ng isang project/module from scratch.
     * San ko din po ba makikita yung mga fields required para po dun sa project? Kasi po yung binigay na document sakin parang pang UI design lang po. Yun lang Ma'am. Sorry po sa abala. Thank you po.
     */
    public function scopeForChannel($builder, $channel)
    {
        if ($channel->exists) {
            return $builder->where('channel_id', $channel->id);
        }

        return $builder;
    }

    public function approve()
    {
        $this->approved = true;

        return $this;
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }


    /**
     * A Community link may have many votes
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function votes()
    {
        return $this->hasMany(CommunityLinkVote::class, 'community_link_id');
    }

    /**
     * Determine if the link has already been submitted
     * @param  string $link
     * @return mixed
     */
    protected function hasAlreadyBeenSubmitted($link)
    {
        return static::where('link', $link)->first();
    }
}
