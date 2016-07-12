@extends('layouts.app')

@section('content')
 	<div class="row">
 		<div class="col-md-8">
 			<h1>Community links</h1>
 			
 				<ul class="Links">
 					@if(count($links))
	 				 	@foreach ($links as $link)
	 						<li class="Links__link">
								<span class="label label-default" style="background: {{ $link->channel->color  }}">{{ $link->channel->title }}</span>

	 							<a href="{{ $link->link }}" target="_blank">
	 								{{ $link->title }}
	 							</a>
	 			
	 							<small>
	 							Contributed By: <a href="#">{{ $link->creator->name }}</a> {{ $link->updated_at->diffForHumans() }}
	 						</small>
	 						</li>			
	 				 	@endforeach
 				 	@else
 				 		<li class="link__link">
 				 			No contributions yet.
 				 		</li>
 				 	@endif

 			</ul>
 		</div>
 	

	 	@include('community.add-link')
 	</div>
@stop