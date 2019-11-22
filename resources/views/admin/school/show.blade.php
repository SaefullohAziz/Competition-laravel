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
							<legend>{{ __('School Data') }}</legend>
							{{ Form::bsText(null, __('Type'), 'type', $school->type, __('Type'), ['disabled' => '']) }}

							{{ Form::bsText(null, __('Name'), 'name', $school->name, __('Name'), ['disabled' => '']) }}

						</fieldset>
						<fieldset class="col-sm-6">
							<legend>{{ __('Details') }}</legend>

							{{ Form::bsEmail(null, __('School Email'), 'email', $school->email, __('School Email'), ['disabled' => ''] ) }}

							{{ Form::bsTextarea(null, __('School Address'), 'address', $school->address, __('School Address'), ['disabled' => ''] ) }}

						</fieldset>
					</div>
				</div>
				<div class="card-footer bg-whitesmoke text-center">
					{{ link_to(route('admin.school.index'),__('Cancel'), ['class' => 'btn btn-danger']) }}
				</div>
			{{ Form::close() }}

		</div>
	</div>
</div>
@endsection