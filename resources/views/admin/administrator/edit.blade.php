@extends('layouts.main')

@section('content')
<div class="row">
	<div class="col-12">

		@if (session('alert-success'))
			<div class="alert alert-success alert-dismissible show fade">
				<div class="alert-body">
					<button class="close" data-dismiss="alert">
						<span>&times;</span>
					</button>
					{{ session('alert-success') }}
				</div>
			</div>
		@endif

		@if (session('alert-danger'))
			<div class="alert alert-danger alert-dismissible show fade">
				<div class="alert-body">
					<button class="close" data-dismiss="alert">
						<span>&times;</span>
					</button>
					{{ session('alert-danger') }}
				</div>
			</div>
		@endif

		<div class="card card-primary">

			{{ Form::open(['route' => ['admin.administrator.update', $administrator->id], 'files' => true, 'method' => 'put']) }}
				<div class="card-body">
					<div class="row">
						<fieldset class="col-sm-6">
							<legend>{{ __('Administrator Data') }}</legend>
							{{ Form::bsText(null, __('Name'), 'name', $administrator->name, __('Name'), ['required' => '']) }}

							{{ Form::bsText(null, __('Username'), 'username', $administrator->username, __('Username') ) }}

							{{ Form::bsText(null, __('Email'), 'email', $administrator->email, __('Email'), ['required' => ''] ) }}

							{{ Form::bsFile(null, __('Photo'), 'photo', old('photo'), [], [__('File must have extension *.jpg/*.jpeg with size 5 MB or less.')]) }}

							{{ Form::bsText(null, __('Date'), 'date', $administrator->date, __('Date')) }}
							
						</fieldset>
					</div>
				</div>
				<div class="card-footer bg-whitesmoke text-center">
					{{ Form::submit(__('Save'), ['class' => 'btn btn-primary']) }}
					{{ link_to(route('admin.administrator.index'),__('Cancel'), ['class' => 'btn btn-danger']) }}
				</div>
			{{ Form::close() }}

		</div>
	</div>
</div>
@endsection

@section('script')
<script>
	$(document).ready(function () {
		$('[name="date"]').keypress(function(e) {
            e.preventDefault();
        }).daterangepicker({
        	locale: {format: 'DD-MM-YYYY'},
        	singleDatePicker: true,
      	});
    });
</script>
@endsection