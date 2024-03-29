<div class="form-group {{ $class }}">
    {{ Form::label($name, $label) }}
    {{ Form::password($name, array_merge(['class' => 'form-control '.($errors->has($name) ? 'is-invalid' : ''), 'placeholder' => $placeholder], $attributes)) }}
    @foreach ($helpTexts as $helpText)
	    <small class="form-text text-muted">
		  {{ $helpText }}
		</small>
	@endforeach
    @if ($errors->has($name))
	    <div class="invalid-feedback" role="alert">
	    	<strong>{{ $errors->first($name) }}</strong>
	    </div>
    @endif
</div>