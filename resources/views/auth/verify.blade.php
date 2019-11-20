@include('layouts.header')

<div id="app">
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                    <div class="login-brand">
                        {{ config('app.name', 'Laravel') }}
                    </div>

                    <div class="card">
                        <div class="card-header"><h4>{{ __('Verify Your Email Address') }}</h4></div>
                        
                        <div class="card-body">
                            @if (session('resent'))
                                <div class="alert alert-success" role="alert">
                                    {{ __('A fresh verification link has been sent to your email address.') }}
                                </div>
                            @endif

                            {{ __('Before proceeding, please check your email for a verification link.') }}
                            {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.
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