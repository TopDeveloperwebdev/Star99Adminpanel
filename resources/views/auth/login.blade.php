@extends('layouts.simple')

@section('content')
    <!-- Page Content -->
    <div class="bg-image" style="background-image:url({{asset('game/assets/background.png')}});">
        <div class="hero-static">
            <div class="content pt-lg-5 pt-md-4" style="">
                <div class="m-0 row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-4">
                        <!-- Sign In Block -->
                            <div class="block-content border border-info rounded-lg">
                                <div class="p-sm-3 px-lg-4 py-lg-5">
                                    <div class="row">
                                      <div class="col-3"></div>
                                      <div class="col-6">
                                       <img src="{{ asset('public/media/favicons/Logo_Base_Color.png') }}" class="img-fluid" alt="">
                                      </div>
                                    </div>
                                    <h3 class="block-title">Sign In</h3>
                                    <p>Welcome, please login.</p>
                                    <!-- Sign In Form -->
                                    <!-- jQuery Validation (.js-validation-signin class is initialized in js/pages/op_auth_signin.min.js which was auto compiled from _es6/pages/op_auth_signin.js) -->
                                    <!-- For more info and examples you can check out https://github.com/jzaefferer/jquery-validation -->
                                    <form class="js-validation-signin" action="{{ route('login') }}" method="POST">
                                    {{ csrf_field() }}
                                        <div class="py-3">
                                           
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-alt form-control-lg {{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
                                                @if ($errors->has('email'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control form-control-alt form-control-lg {{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" name="password" placeholder="Password" required>
                                                @if ($errors->has('password'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <!-- <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                                    <label class="custom-control-label font-w400" for="login-remember">Remember Me</label>
                                                </div>
                                            </div> -->
<?php /*                                            
                                            {!! NoCaptcha::renderJs() !!}

                                            <div class="form-group {{ $errors->has('g-recaptcha-response') ? "has-error" :"" }}">
                                                {!! NoCaptcha::display() !!}
                                                @if ($errors->has('g-recaptcha-response'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
*/?>                                        
                                        <div class="form-group row">
                                            <div class="col-md-6 col-xl-5">
                                                <button type="submit" class="btn btn-block btn-primary">
                                                    <i class="fa fa-fw fa-sign-in-alt mr-1"></i> Sign In
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- END Sign In Form -->
                                </div>
                            </div>

                        <!-- END Sign In Block -->
                    </div>
                </div>
            </div>
       
        </div>
    </div>
    <!-- END Page Content -->

@endsection

<style>
    .invalid-feedback {
        display: block !important;
    }
</style>