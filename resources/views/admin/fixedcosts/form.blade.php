<div class="row mB-40">
    <div class="col-sm-8">
        <div class="bgc-white p-20 bd">

            {!! Form::myInput('text', 'project_name', 'Project Name') !!}

            {!! Form::myTextArea('description', 'Description') !!}

            {!! Form::myInput('text', 'tcp', 'Total Contract Price') !!}

            {!! Form::myInput('date', 'estimated_start_date', 'Start Date') !!}

            {!! Form::myInput('date', 'estimated_end_date', 'End Date') !!}

            {!! Form::mySelect('status', 'Status', config('variables.project_status'), null, ['class' => 'form-control select2']) !!}

        </div>
    </div>

</div>