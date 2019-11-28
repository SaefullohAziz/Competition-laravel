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

			{{ Form::open() }}
				<div class="card-body">
					<div class="row">
						<fieldset class="col-sm-6">
							<legend>{{ __('Judge Data') }}</legend>
							{{ Form::bsText(null, __('Username'), 'username', $judge->username, __('Username'), ['disabled' => '']) }}

							{{ Form::bsText(null, __('Name'), 'name', $judge->name, __('Name'), ['disabled' => '']) }}

							{{ Form::bsText(null, __('Email'), 'email', $judge->email, __('Email'), ['disabled' => '']) }}

							{{ Form::bsText(null, __('Gender'), 'gender', $judge->gender, __('Gender'), ['disabled' => '']) }}

						</fieldset>
						<fieldset class="col-sm-6">
							<legend>{{ __('Details') }}</legend>
							{{ Form::bsText(null, __('Address'), 'address', $judge->address, __('Address'), ['disabled' => '']) }}

							{{ Form::bsText(null, __('Carrier'), 'carrier', $judge->carrier, __('Carrier'), ['disabled' => '']) }}

							{{ Form::bsText(null, __('Organitation'), 'organitation', $judge->organitation, __('Organitation'), ['disabled' => '']) }}

							<img src="{!! asset('img/avatar/'.$judge->photo) !!}" height="155x" width="155px">
							
						</fieldset>
					</div>
				</div>
				<div class="card-footer bg-whitesmoke text-center">
					{{ link_to(route('admin.juri.index'),__('Cancel'), ['class' => 'btn btn-danger']) }}
				</div>
			{{ Form::close() }}

		</div>
	</div>
</div>
@endsection