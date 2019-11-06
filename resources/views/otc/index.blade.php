@extends('layouts.app')

@section('title', '| Otc Index')

@section('header')
<link rel="stylesheet" href="{{ asset('css/otc.css') }}">
@endsection

@section('content')
<div class="row m-0">
	<div class="col-md-10 offset-md-1">
		<div class="text-center text-20px">
			Latest Matches
		</div>
		<div class="">
			<div class="row" id="latest-matches">
				<div class="col-sm-3 b-w-0 b-w-b-1 b-c-blue text-right">Name</div>
				<div class="col-sm-3 b-w-0 b-w-b-1 b-c-blue text-left">Rank</div>
				<div class="col-sm-3 b-w-0 b-w-b-1 b-c-blue text-center">Detected At</div>
				<div class="col-sm-3 b-w-0 b-w-b-1 b-c-blue text-center">Type</div>
				@foreach ($matches as $match)
			<div class="col-sm-3 text-right">{{ $match->player_name }}</div>
				<div class="col-sm-3 text-left">{{ $match->rank }}</div>
				<div class="col-sm-3 text-center">{{ date('d M Y - g:i A', strtotime($match->updated_at) + 7200 - 21600) }}</div>
				<div class="col-sm-3 text-center">{{ $match->type }}</div>
				@endforeach
			</div>
		</div>
	</div>
</div>
@endsection

@section('footer')
<script>
</script>
@endsection