@extends('admin.default')

@section('page-header')
	Variable Costs <small>{{ trans('app.update_item') }}</small>
@stop

@section('content')
	{!! Form::model($item, [
			'action' => ['VariableCostController@update', $item->id],
			'method' => 'put', 
			'files' => true
		])
	!!}

		@include('admin.othercosts.form')

		<button type="submit" class="btn btn-primary">{{ trans('app.edit_button') }}</button>
		
	{!! Form::close() !!}
	
@stop
