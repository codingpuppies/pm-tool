@extends('admin.default')

@section('page-header')
    Other Costs
    <small>{{ trans('app.manage') }}</small>
@endsection

@section('content')

    <div class="mB-20">

        <form action="{{ route(ADMIN . '.othercosts.create') }}" method="GET" id="frm_fixed_costs">
            <div class="row">
                <div class="col-md-8">

                    <button class="btn btn-info">
                        {{ trans('app.add_button') }}
                    </button>

                </div>
                <div class="col-md-2  pull-right">
                    <select class="form-control" name="month" id="month"
                            onchange="submitForm();">
                        @for($month=0;$month<12;$month++)
                            <option value="{{$month}}"
                                    @if($_month==$month) selected @endif>{{date_format(date_create("2019-".$month."-01"),"F")}}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-2  pull-right">

                    <select class="form-control" name="year" id="year" onchange="submitForm();">
                        @for($year=2019;$year<2025;$year++)
                            <option value="{{$year}}" @if($_year==$year) selected @endif>{{$year}}</option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-6 pull-right">

                </div>
            </div>

        </form>
    </div>

    <div class="layers bd bgc-white p-20">
        <div class="layer w-100">
            <div class="peers ai-sb fxw-nw">
                <div class="peer peer-greed">
                    <h6 class="lh-1">Total Other Cost
                        for {{date_format(date_create("2019-".$_month."-01"),"F")}} {{$_year}}</h6>
                </div>
                <div class="peer">
                    <h6>{{getAmountAttribute($total_expenses)}}</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="bgc-white bd bdrs-3 p-20 mB-20 mT-20">
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

                    <td>{{ getAmountAttribute($item->amount) }}</td>
                    <td>
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <a href="{{ route(ADMIN . '.othercosts.edit', $item->id) }}"
                                   title="{{ trans('app.edit_title') }}" class="btn btn-primary btn-sm"><span
                                            class="ti-pencil"></span></a></li>
                            <li class="list-inline-item">
                                {!! Form::open([
                                    'class'=>'delete',
                                    'url'  => route(ADMIN . '.othercosts.destroy', $item->id),
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
    <div class="layers bd bgc-white p-20">
        <div class="layer w-100">
            <div class="peers ai-sb fxw-nw">
                <div class="peer peer-greed">
                    <h6 class="lh-1">Total Other Cost
                        for {{date_format(date_create("2019-".$_month."-01"),"F")}} {{$_year}}</h6>
                </div>
                <div class="peer">
                    <h6>{{getAmountAttribute($total_expenses)}}</h6>
                </div>
            </div>
        </div>
    </div>

    <script>
        function submitForm() {
            const form = document.getElementById("frm_fixed_costs");
            form.action = "/admin/othercosts";
            form.submit();
        }
    </script>

@endsection