@extends('admin.default')

@section('page-header')
    Variable Costs
    <small>{{ trans('app.manage') }}</small>
@endsection

@section('content')

    <div class="mB-20">

        <form action="{{ route(ADMIN . '.othercosts.create') }}" method="GET" id="frm_fixed_costs">
            <div class="row">
                <div class="col-md-8">

                    <button class="btn btn-info">
                        Estimate
                    </button>

                    <button class="btn btn-success">
                        Actual
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


    <div class="bgc-white bd bdrs-3 p-20 mB-20 mT-20">
        <table class="table table-striped table-bordered mB-0" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Developers</th>
                @foreach($projects as $project)
                <th style="padding:0!important ;">
                    <table class="table text-center" style="margin-bottom:0!important;">
                        <tr>
                            <td colspan="2" class="c-white"
                                style="background-color:{{ config('variables.table_column')[$project->id%4]  }};">
                                {{$project->project_name}}
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:0!important;background-color:{{ config('variables.table_est_act')[$project->id%4][0]  }}"><h6>EST</h6></td>
                            <td style="padding:0!important;background-color:{{ config('variables.table_est_act')[$project->id%4][1] }}"><h6>ACT</h6></td>
                        </tr>
                    </table>
                </th>
                @endforeach
                <th>Action</th>
            </tr>
            </thead>


            <tbody>
            @foreach ($developers as $item)
                <tr>
                    <td>{{ $item->first_name }} {{ $item->last_name }}</td>
                </tr>
            @endforeach
            </tbody>

        </table>
    </div>

    <script>
        function submitForm() {
            const form = document.getElementById("frm_fixed_costs");
            form.action = "/admin/othercosts";
            form.submit();
        }
    </script>

@endsection