@extends('layouts.master')
@section('content')


<div class="container">
	<div class="row clearfix">
	@include('layouts.selfCenter')


@if (Session::has('userId'))
	{{Session::get('userId')}}
@endif

	</div>
</div>
@stop