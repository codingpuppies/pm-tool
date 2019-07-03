<div class="row mB-40">
    <div class="col-sm-8">

        <div class="bgc-white p-20 bd">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="month">Month</label>
                        <select class="form-control" name="month">
                            @for($month=0;$month<12;$month++)
                                <option value="{{$month}}"
                                        @if($_month==$month) selected @endif>
                                    {{date_format(date_create("2019-".$month."-01"),"F")}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="year">Year</label>

                        <select class="form-control" name="year">
                            @for($year=2019;$year<2025;$year++)
                                <option value="{{$year}}" @if($_year==$year) selected @endif>{{$year}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
            <hr>
            @foreach(config('variables.particulars') as $particular)
                <div class="row">
                    <div class="col-md-6">
                        {!! Form::mySelect('particulars[]', 'Particular', config('variables.particulars'), $particular, ['class' => 'form-control select2']) !!}
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="year">Amount</label>
                            @if($particular=='SALARY')
                                <input type="number" class="form-control" name="amounts[]" value="{{$salary}}">
                            @else
                                @if(isset($items['particular']))
                                    @if($particular == $items['particular'])
                                        <input type="number" class="form-control" name="amounts[]"
                                               value="{{$items['amount']}}">
                                    @else
                                        <input type="number" class="form-control" name="amounts[]" value="0.00">
                                    @endif
                                @else
                                    <input type="number" class="form-control" name="amounts[]" value="0.00">
                                @endif

                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>