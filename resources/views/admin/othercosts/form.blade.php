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
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="year">Particular</label>

                        @if(!isset($item->particular))
                            <input type="text" class="form-control" name="particular" value="">
                        @else
                            <input type="text" class="form-control" name="particular" value="{{$item->particular}}">
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="year">Amount</label>
                        @if(!isset($item->amount))
                            <input type="number" class="form-control" name="amount" value="0">
                        @else
                            <input type="number" class="form-control" name="amount" value="{{$item->amount}}">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>