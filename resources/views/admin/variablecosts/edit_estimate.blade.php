@extends('admin.default')

@section('page-header')
    Variable Costs - Estimates Update
    <small>{{ trans('app.manage') }}</small>
@endsection

@section('content')

    <div class="mB-20">

        <form action="{{ route(ADMIN . '.variablecosts.create') }}" method="GET" id="frm_fixed_costs">
            <div class="row">
                <div class="col-md-8">

                    <button class="btn btn-info">
                        Update
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
        <table class="table table-striped mB-0" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th class="text-center align-middle" style="background-color:{{config('variables.developer_column')}}">Developers</th>


            @foreach($projects as $project)

                    <td style="padding:0!important; width:10%">
                        <table class="table text-center"
                               style="height:100%; border:0 !important;margin-bottom:0!important;">
                            <tr>
                                <td colspan="2" class="c-white"
                                    style="background-color:{{ config('variables.table_column')[$project->id%4]  }};">
                                    {{$project->project_name}}
                                </td>
                            </tr>
                            <tr>
                                <td style="width:50%;margin:0!important;background-color:{{ config('variables.table_est_act')[$project->id%4][0]  }}">
                                    <h6>EST</h6>
                                </td>
                            </tr>
                        </table>
                    </td>
                @endforeach
                <td style="padding:0!important ;">
                    <table class="table text-center"
                           style="height:100%; border:0 !important;margin-bottom:0!important;">
                        <tr>
                            <td colspan="2" class="c-white"
                                style="background-color:#9c27b0;">
                                Total
                            </td>
                        </tr>
                        <tr>
                            <td style="width:50%;margin:0!important;background-color:#f3e5f5">
                                <h6>EST</h6>
                            </td>
                        </tr>
                    </table>
                </td>
                <th class="text-center align-middle" style="background-color:{{config('variables.action_column')}}">Action</th>

            </tr>
            </thead>

            <tbody>
            @foreach ($developers as $item)
                <tr>
                    <form>
                        <td>{{ $item->first_name }} {{ $item->last_name }}</td>
                        @foreach($projects as $project)
                            <td style="padding:0!important ;">
                                <table class="table text-center"
                                       style="height:100%; border:0 !important;margin-bottom:0!important;">
                                    <tr>
                                        <td style="width:50%;margin:0!important;background-color:{{ config('variables.table_est_act')[$project->id%4][0]  }}">
                                            <input placeholder="0" type="number" class="form-control"
                                                   value="@if(isset($assigned_developers[$item->id][$project->id])){{trim($assigned_developers[$item->id][$project->id]->estimate_effort)}}@endif">
                                        </td>

                                    </tr>
                                </table>
                            </td>

                        @endforeach
                        <td style="padding:0!important; background-color:#f3e5f5;">
                            <table class="table text-center"
                                   style="height:100% !important; border:0 !important;margin-bottom:0!important;">
                                <tr>
                                    <td style="height:100% !important; width:50%;margin:0!important;background-color:#f3e5f5">
                                        <h6>
                                            <b>{{$total_developer_estimated[$item->id]}}%</b>
                                        </h6>
                                    </td>

                                </tr>
                            </table>
                        </td>
                    </form>
                </tr>
            @endforeach
            <tr>
                <td><b>TOTAL</b></td>
                @foreach($projects as $project)
                    <td style="padding:0!important ;">
                        <table class="table text-center"
                               style="height:100%; border:0 !important;margin-bottom:0!important;">
                            <tr>
                                <td style="width:50%;margin:0!important;background-color:{{ config('variables.table_est_act')[$project->id%4][0]  }}">
                                    <h6>
                                        @if(isset($assigned_developers[$item->id][$project->id]))
                                            <b>{{$assigned_developers[$item->id][$project->id]->estimate_effort}}%</b>
                                        @else
                                            <b>0%</b>
                                        @endif
                                    </h6>
                                </td>

                            </tr>
                        </table>
                    </td>

                @endforeach
                <td style="padding:0!important ;">
                    <table class="table text-center"
                           style="height:100%; border:0 !important;margin-bottom:0!important;">

                        <tr>
                            <td style="width:50%;margin:0!important;background-color:#f3e5f5">
                                <h6>
                                    <b>{{$total_developer_estimated[$item->id]}}%</b>
                                </h6>
                            </td>

                        </tr>
                    </table>
                </td>
            </tr>
            </tbody>

        </table>
    </div>

    <script>
        function submitForm() {
            const form = document.getElementById("frm_fixed_costs");
            form.action = "/admin/variablecosts";
            form.submit();
        }
    </script>

@endsection