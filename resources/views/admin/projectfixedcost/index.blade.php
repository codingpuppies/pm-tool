@extends('admin.default')

@section('page-header')
    Project Fixed Costs Allocation
    <small>{{ trans('app.manage') }}</small>
@endsection

@section('content')

    <div class="mB-20">

        <form action="{{ route(ADMIN . '.projectfixedcost.index') }}" method="GET" id="frm_fixed_costs">
            <div class="row">
                <div class="col-md-7">
                    <button class="btn btn-info" id="btn-estimate" onclick="edit_allocation()">
                        Edit
                    </button>


                </div>
                <div class="col-md-2  pull-right">

                </div>
                <div class="col-md-2  pull-right">

                    <select class="form-control" name="year" id="year">
                        @for($year=2019;$year<2025;$year++)
                            <option value="{{$year}}" @if($_year==$year) selected @endif>{{$year}}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-1  pull-right">
                    <button class="form-control btn-primary" onclick="submitForm();">GO</button>
                </div>
            </div>

        </form>
    </div>


    <div class="bgc-white bd bdrs-3 p-20 mB-20 mT-20">
        <table id="dataTable" class="table table-hover table-striped mB-0 text-center" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th class="text-center align-middle" style="background-color:{{config('variables.developer_column')}}">
                    Project
                </th>
                @for($month=0;$month<12;$month++)
                    <td class="c-white"
                        style="background-color:{{ config('variables.table_column')[$month]}};">{{date_format(date_create("2019-".($month+1)."-01"),"M")}}</td>
                @endfor

                <td style="padding:0!important ;">
                    <table class="table text-center"
                           style="height:100%; border:0 !important;margin-bottom:0!important;">
                        <tr>
                            <td colspan="2" class="c-white"
                                style="background-color:#9c27b0;">
                                Total
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            </thead>

            <tbody>
            @foreach($projects as $project)
                <tr>
                    <td style="padding:0!important ;">
                        <table class="table text-center"
                               style="height:100%; border:0 !important;margin-bottom:0!important;">
                            <tr>
                                <td colspan="2">
                                    {{$project->project_name}}
                                </td>
                            </tr>
                        </table>
                    </td>
                    @for($month=1;$month<=12;$month++)
                        @if(isset($project_fixed_allocation[$project->id][$month]))
                            @foreach($allocated_efforts as $effort)
                                @if($effort->project_id == $project->id && $effort->month == $month)
                                    <td><b>{{$effort->percentage}}%</b></td>
                                @endif
                            @endforeach
                        @else
                            <td>0</td>
                        @endif
                    @endfor
                    @if(isset($total_allocated_effort[$project->id]))
                        <td><b>{{$total_allocated_effort[$project->id]}}%</b></td>
                    @else
                        <td>0</td>
                    @endif
                </tr>
            @endforeach

            </tbody>

        </table>
    </div>

    <script>
        function submitForm() {
            const form = document.getElementById("frm_fixed_costs");
            form.action = "/admin/projectfixedcost";
            form.submit();
        }

        function edit_allocation() {
            const form = document.getElementById("frm_fixed_costs");
            form.action = "{{ route(ADMIN . '.projectfixedcost.edit',1) }}";
            form.submit();
        }

    </script>

@endsection