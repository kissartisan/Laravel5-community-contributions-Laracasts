<ul class="list-group">
    @if(count($links))
        @foreach ($links as $link)
            <li class="list-group-item">
                <form method="POST" action="/votes/{{ $link->id }}" class="CommunityLinkForm">
                    {{ csrf_field() }}

                    {{--
                        Auth::check() is use to determine if the user is logged in
                        votedFor is used when the user voted for the link
                    --}}
                    <button class="btn {{ Auth::check() && Auth::user()->votedFor($link) ? 'btn-success' : 'btn-default' }} {{ Auth::guest() ? 'disabled' : '' }}">
                        {{ $link->votes->count() }}
                    </button>

                </form>

                <a href="/community/{{ $link->channel->slug }}" class="label label-default" style="background: {{ $link->channel->color  }}">{{ $link->channel->title }}</a>

                <a href="{{ $link->link }}" target="_blank">
                    {{ $link->title }}
                </a>

                <small>
                Contributed By: <a href="#">{{ $link->creator->name }}</a> {{ $link->updated_at->diffForHumans() }}
            </small>
            </li>
        @endforeach
        {{-- Appends the request in the url --}}
        {{ $links->appends(request()->query())->links() }}
    @else
        <li class="link__link">
            No contributions yet.
        </li>
    @endif

</ul>