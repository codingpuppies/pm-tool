@extends('admin.default')

@section('page-header')
	Project Developers <small>{{ trans('app.add_new_item') }}</small>
@stop

@section('content')
	{!! Form::open([
			'action' => ['ProjectDeveloper@store'],
			'files' => true
		])
	!!}

		@include('admin.projects.form')

		<button type="submit" class="btn btn-primary">{{ trans('app.add_button') }}</button>
		
	{!! Form::close() !!}
	
@stop
