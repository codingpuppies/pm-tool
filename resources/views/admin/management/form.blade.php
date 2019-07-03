<div class="row mB-40">
	<div class="col-sm-8">
		<div class="bgc-white p-20 bd">
			{!! Form::myInput('text', 'employee_number', 'Employee Number') !!}

			{!! Form::myInput('text', 'first_name', 'First Name') !!}

			{!! Form::myInput('text', 'middle_name', 'Middle Name') !!}

			{!! Form::myInput('text', 'last_name', 'Last Name') !!}

			{!! Form::myInput('email', 'email', 'Email') !!}

			{!! Form::myInput('text', 'salary', 'Salary') !!}

			{!! Form::mySelect('position', 'Position', config('variables.mgt_position'), null, ['class' => 'form-control select2']) !!}

			{!! Form::mySelect('department', 'Department', config('variables.mgt_department'), null, ['class' => 'form-control select2']) !!}

			{!! Form::myInput('password', 'password', 'Password') !!}

			{!! Form::myInput('password', 'password_confirmation', 'Password again') !!}

		</div>  
	</div>
</div>