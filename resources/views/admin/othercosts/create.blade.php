@extends('admin.default')

@section('page-header')
	Other Costs Particular <small>{{ trans('app.add_new_item') }}</small>
@stop

@section('content')
	{!! Form::open([
			'action' => ['OtherCostController@store'],
			'files' => true
		])
	!!}

		@include('admin.othercosts.form')

		<button type="submit" class="btn btn-primary">{{ trans('app.add_button') }}</button>
		
	{!! Form::close() !!}
	
@stop
