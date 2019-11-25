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
							<legend>{{ __('User Data') }}</legend>
							{{ Form::bsText(null, __('Username'), 'username', $user->username, __('Username'), ['disabled' => '']) }}

							{{ Form::bsText(null, __('Name'), 'name', $user->name, __('Name'), ['disabled' => '']) }}

							{{ Form::bsText(null, __('Email'), 'email', $user->email, __('Email'), ['disabled' => '']) }}

						</fieldset>
						<fieldset class="col-sm-6">
							<legend>{{ __('Details') }}</legend>

							<img src="{!! asset('img/avatar/'.$user->photo) !!}" height="270x" width="270px">

						</fieldset>
					</div>
				</div>
				<div class="card-footer bg-whitesmoke text-center">
					{{ link_to(route('admin.user.index'),__('Cancel'), ['class' => 'btn btn-danger']) }}
				</div>
			{{ Form::close() }}

		</div>
	</div>
</div>
@endsection