@extends('admin.default')

@section('page-header')
	Manager <small>{{ trans('app.add_new_item') }}</small>
@stop

@section('content')
	{!! Form::open([
			'action' => ['DeveloperController@store'],
			'files' => true
		])
	!!}

		@include('admin.management.form')

		<button type="submit" class="btn btn-primary">{{ trans('app.add_button') }}</button>
		
	{!! Form::close() !!}
	
@stop
