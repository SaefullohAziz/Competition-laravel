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

			{{ Form::open(['route' => 'admin.competition.store', 'files' => true]) }}
				<div class="card-body">
					<div class="row">
						<fieldset class="col-sm-6">
							<legend>{{ __('Competition Data') }}</legend>
							{{ Form::bsText(null, __('Name'), 'name', old('name'), __('Name'), ['required' => '']) }}

							{{ Form::bsText(null, __('Alias'), 'alias', old('alias'), __('Alias') ) }}

							{{ Form::bsText(null, __('Theme'), 'theme', old('theme'), __('Theme') ) }}

							{{ Form::bsFile(null, __('Image'), 'image', old('image'), [], [__('File must have extension *.jpg/*.jpeg with size 5 MB or less.')]) }}

							{{ Form::bsText(null, __('Date'), 'date', old('date'), __('Date'), ['required' => '']) }}
							
						</fieldset>
						<fieldset class="col-sm-6">
							<legend>{{ __('Details') }}</legend>

							{{ Form::bsTextarea(null, __('Description'), 'description', old('description'), __('Description')) }}

							{{ Form::bsTextarea(null, __('Terms And Conditions'), 'terms_and_conditions', old('terms_and_conditions'), __('Terms And Conditions')) }}

						</fieldset>
					</div>
				</div>
				<div class="card-footer bg-whitesmoke text-center">
					{{ Form::submit(__('Save'), ['class' => 'btn btn-primary']) }}
					{{ link_to(route('admin.competition.index'),__('Cancel'), ['class' => 'btn btn-danger']) }}
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