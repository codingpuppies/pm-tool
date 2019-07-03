@extends('admin.default')

@section('page-header')
    Fixed Costs
    <small>{{ trans('app.manage') }}</small>
@endsection

@section('content')

    <div class="mB-20">


        @if(count($items)==0)
            <form action="{{ route(ADMIN . '.fixedcosts.create') }}" method="GET" id="frm_fixed_costs">
                <button class="btn btn-info">
                    {{ trans('app.add_button') }}
                </button>
                @else
                    <form action="{{ route(ADMIN . '.fixedcosts.edit',1) }}" method="GET" id="frm_fixed_costs">
                        <button class="btn btn-info">
                            {{ trans('app.edit_button') }}
                        </button>
                        @endif

                        <select class="form-control pull-right col-md-1" name="year" id="year" onchange="submitForm();">
                            @for($year=2019;$year<2025;$year++)
                                <option value="{{$year}}" @if(date('Y')==$year) selected @endif>{{$year}}</option>
                            @endfor
                        </select>
                        <select class="form-control pull-right col-md-2" name="month" id="month"
                                onchange="submitForm();">
                            @for($month=0;$month<12;$month++)
                                <option value="{{$month}}"
                                        @if(date('m')==$month) selected @endif>{{date_format(date_create("2019-".$month."-01"),"F")}}</option>
                            @endfor
                        </select>
                    </form>
    </div>

    <div class="bgc-white bd bdrs-3 p-20 mB-20">

        <table class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Month Year</th>
                <th>Total Fixed Cost Expenses</th>
            </tr>
            </thead>

            <tfoot>
            <tr>
                <th>Month Year</th>
                <th>Total Fixed Cost Expenses</th>
            </tr>
            </tfoot>

            <tbody>
            <tr>
            <td>month</td>

            <td>{{$total_expenses}}</td>
            </tr>
            </tbody>

        </table>
    </div>

    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <table id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Particular</th>
                <th>Amount</th>
                <th>Action</th>
            </tr>
            </thead>

            <tfoot>
            <tr>
                <th>Particular</th>
                <th>Amount</th>
                <th>Action</th>
            </tr>
            </tfoot>

            <tbody>
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item->particular }}</td>

                    <td>{{ $item->amount }}</td>

                    <td>
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <a href="{{ route(ADMIN . '.fixedcosts.edit', $item->id) }}"
                                   title="{{ trans('app.edit_title') }}" class="btn btn-primary btn-sm"><span
                                            class="ti-pencil"></span>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                {!! Form::open([
                                    'class'=>'delete',
                                    'url'  => route(ADMIN . '.projects.destroy', $item->id),
                                    'method' => 'DELETE',
                                    ])
                                !!}

                                <button class="btn btn-danger btn-sm" title="{{ trans('app.delete_title') }}"><i
                                            class="ti-trash"></i></button>

                                {!! Form::close() !!}
                            </li>
                        </ul>
                    </td>
                </tr>
            @endforeach
            </tbody>

        </table>
    </div>

    <script>
        function submitForm() {
            const form = document.getElementById("frm_fixed_costs");
            form.submit();
        }
    </script>

@endsection