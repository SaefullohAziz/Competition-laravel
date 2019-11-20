@include('layouts.header')

<div id="app">
  <section class="section">
    <div class="container mt-5">
      <div class="row">
        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
          <div class="login-brand">
            {{ config('app.name', 'Laravel') }}
          </div>

          <div class="card card-primary">
            <div class="card-header"><h4>{{ __('Reset Password') }}</h4></div>

            <div class="card-body">
              {{ Form::open(['route' => 'password.email', 'files' => true]) }}

                {{ Form::bsEmail(null, __('E-Mail'), 'email', old('email'), __('E-Mail'), ['required' => '']) }}

                <div class="form-group">
                    {{ Form::submit(__('Send Password Reset Link'), ['name' => 'submit', 'class' => 'btn btn-block btn-primary']) }}
                </div>

              {{ Form::close() }}

            </div>
          </div>
          <div class="simple-footer">
            Copyright &copy; {{ config('app.name', 'Laravel') }}
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

@include('layouts.footer')