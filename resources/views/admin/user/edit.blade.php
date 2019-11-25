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

			{{ Form::open(['route' => ['admin.contest.update', $contest->id], 'files' => true, 'method' => 'put']) }}
				<div class="card-body">
					<div class="row">
						<fieldset class="col-sm-6">
							<legend>{{ __('Contest Data') }}</legend>
							{{ Form::bsSelect(null, __('Competition Name'), 'competition_id', $competitions, $contest->competition_id, __('Competition Name'), ['required' => '']) }}

							{{ Form::bsText(null, __('Name'), 'name', $contest->name, __('Name'), ['required' => '']) }}

							{{ Form::bsText(null, __('Contest Limit'), 'limit', $contest->limit, __('Contest Limit') ) }}

						</fieldset>
						<fieldset class="col-sm-6">
							<legend>{{ __('Details') }}</legend>

							{{ Form::bsTextarea(null, __('Implementation Instructions'), 'implementation_instruction', $contest->implementation_instruction, __('Implementation Instructions') ) }}

							{{ Form::bsTextarea(null, __('Technical Instructions'), 'techincal_instructions', $contest->techincal_instructions, __('Technical Instructions') ) }}

							{{ Form::bsTextarea(null, __('Terms And Conditions'), 'terms_and_conditions', $contest->terms_and_conditions, __('Terms And Conditions') ) }}

						</fieldset>
					</div>
				</div>
				<div class="card-footer bg-whitesmoke text-center">
					{{ Form::submit(__('Save'), ['class' => 'btn btn-primary']) }}
					{{ link_to(route('admin.contest.index'),__('Cancel'), ['class' => 'btn btn-danger']) }}
				</div>
			{{ Form::close() }}

		</div>
	</div>
</div>
@endsection