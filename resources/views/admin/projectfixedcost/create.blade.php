@extends('admin.default')

@section('page-header')
	Variable Costs Estimate <small>{{ trans('app.add_new_item') }}</small>
@stop

@section('content')
	{!! Form::open([
			'action' => ['VariableCostController@store'],
			'files' => true
		])
	!!}

		@include('admin.othercosts.form')

		<button type="submit" class="btn btn-primary">{{ trans('app.add_button') }}</button>
		
	{!! Form::close() !!}
	
@stop
