@extends('admin.default')

@section('page-header')
    Project Developers
    <small>{{ trans('app.update_item') }}</small>
@stop

@section('content')
    <div class="row">
        <div class="col-sm-6">

            <div class="bd bgc-white p-20">
                <div class="layers">
                    <!-- Widget Title -->
                    <div class="layer w-100 mB-20">
                        <h6 class="lh-1">Project Details</h6>
                    </div>

                    <!-- Today Weather -->
                    <div class="layer w-100">
                        <div class="peers ai-c jc-sb fxw-nw">
                            <div class="peer peer-greed">
                                <div class="layers">
                                    <!-- Temprature -->
                                    <div class="layer w-100">
                                        <div class="peers fxw-nw ai-c">
                                            <div class="peer mR-20">
                                                <h3>{{$item->project_name}}</h3>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Condition -->
                                    <div class="layer w-100">
                                        <span class="fw-600 c-grey-600">{{$item->description}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="peer">
                                <div class="layers ai-fe">
                                    <div class="layer">
                                        <h5 class="mB-5">{{$item->estimated_start_date}}</h5>
                                    </div>
                                    <div class="layer">
                                        <span class="fw-600 c-grey-600">Nov, 01 2017</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Today Weather Extended -->
                    <div class="layer w-100 mY-30">
                        <div class="layers bdB">
                            <div class="layer w-100 bdT pY-5">
                                <div class="peers ai-c jc-sb fxw-nw">
                                    <div class="peer">
                                        <span>TCP</span>
                                    </div>
                                    <div class="peer ta-r">
                                        <span class="fw-600 c-grey-800">{{$item->tcp}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="layer w-100 bdT pY-5">
                                <div class="peers ai-c jc-sb fxw-nw">
                                    <div class="peer">
                                        <span>Estimated Duration</span>
                                    </div>
                                    <div class="peer ta-r">
                                        <span class="fw-600 c-grey-800">{{ compute_month_diff($item->estimated_start_date,$item->estimated_end_date)}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="layer w-100 bdT pY-5">
                                <div class="peers ai-c jc-sb fxw-nw">
                                    <div class="peer">
                                        <span>Running Duration</span>
                                    </div>
                                    <div class="peer ta-r">
                                        <span class="fw-600 c-grey-800">{{ compute_month_diff($item->estimated_start_date,now())}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Week Forecast -->
                    <div class="layer w-100">
                        <div class="peers peers-greed ai-fs ta-c">
                            <div class="peer">
                                <h6 class="mB-10">MON</h6>
                                <canvas class="sleet" width="30" height="30"></canvas>
                                <span class="d-b fw-600">32<sup>°F</sup>
                            </div>
                            <div class="peer">
                                <h6 class="mB-10">TUE</h6>
                                <canvas class="clear-day" width="30" height="30"></canvas>
                                <span class="d-b fw-600">30<sup>°F</sup>
                            </div>
                            <div class="peer">
                                <h6 class="mB-10">WED</h6>
                                <canvas class="partly-cloudy-day" width="30" height="30"></canvas>
                                <span class="d-b fw-600">28<sup>°F</sup>
                            </div>
                            <div class="peer">
                                <h6 class="mB-10">THR</h6>
                                <canvas class="cloudy" width="30" height="30"></canvas>
                                <span class="d-b fw-600">32<sup>°F</sup>
                            </div>
                            <div class="peer">
                                <h6 class="mB-10">FRI</h6>
                                <canvas class="snow" width="30" height="30"></canvas>
                                <span class="d-b fw-600">24<sup>°F</sup>
                            </div>
                            <div class="peer">
                                <h6 class="mB-10">SAT</h6>
                                <canvas class="wind" width="30" height="30"></canvas>
                                <span class="d-b fw-600">28<sup>°F</sup>
                            </div>
                            <div class="peer">
                                <h6 class="mB-10">SUN</h6>
                                <canvas class="sleet" width="30" height="30"></canvas>
                                <span class="d-b fw-600">32<sup>°F</sup>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">

            {!! Form::model([], [
                    'action' => ['ProjectDeveloperController@update', $item->id],
                    'method' => 'put',
                    'files' => true
                ])
            !!}

            <div class="row mB-40">

                <div class="col-sm-12">
                    <div class="bgc-white p-20 bd">
                        <div class="layer w-100 mB-20">
                            <h6 class="lh-1">Assigned Developers</h6>
                        </div>
                        <div class="form-group">
                            <label for="slct_pm">Project Manager</label>

                            <select class="form-control select2" multiple="multiple" id="pm">
                                @foreach($pm as $pm_record)
                                    <option selected="selected" value="{{$pm_record->id}}">{{$pm_record->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="slct_dev">Developers</label>

                            <select class="form-control select2" multiple="multiple" id="dev">
                                @foreach($devs as $dev_record)
                                    <option selected="selected" value="{{$dev_record->id}}">{{$dev_record->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <label></label>
                    </div>
                </div>

            </div>

            <button type="submit" class="btn btn-primary">{{ trans('app.edit_button') }}</button>

            {!! Form::close() !!}

        </div>
    </div>
    <script>
        $(document).ready(function(){
            $('#pm').val(['2']);
            $('#pm').trigger('change');
        });
    </script>

@stop
