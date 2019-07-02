@extends('admin.default')

@section('page-header')
	Developer <small>{{ trans('app.add_new_item') }}</small>
@stop

@section('content')
	{!! Form::open([
			'action' => ['DeveloperController@store'],
			'files' => true
		])
	!!}

		@include('admin.developers.form')

		<button type="submit" class="btn btn-primary">{{ trans('app.add_button') }}</button>
		
	{!! Form::close() !!}
	
@stop
