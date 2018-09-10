@extends('layouts.app')

@section('content')
    <div class="flex-center position-ref full-height not-auth-shorter-form">
        <div class="content">
            <div class="col-12" style="background-color: #ffffff; padding: 15px">
                <div class="col-md-12 shorter-result">
                </div>
                {{--todo action="/ajax/short-link"  переделать на имя роута--}}
                <form id="login-form" action="/ajax/short-link" method="post" role="form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <input type="text" name="link" id="link" tabindex="1" class="form-control col-6"
                               placeholder="http://site.ru" value="" style="display: inline">
                        <input type="button" name="short-link" style="margin-top: -5px" class="btn btn-primary "
                               value="Сократить">
                    </div>
                </form>
            </div>
        </div>

    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>


                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="email"
                                       class="col-sm-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                           name="email" value="{{ old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                           class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                           name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember"
                                               id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>

                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
		$(document).ready(function () {
			$(document).on('click', 'input[name="short-link"]', function () {
				var link = $('input[name="link"]').val();

				$.ajax({
					type: 'post',
					url: '/ajax/short-link',
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					data: {
						link: link,
					},
					success: function (data) {
						console.log(data);
						var result = JSON.parse(data);

						var html = '<div class="row"><div class="col-md-4"><h1 class="data-link">' + result.link + '</h1></div>' +
							'<div class="col-md-8" style="padding-bottom: 10px">' +
							'<img class="copy-link-icon" src="http://shorter.loc/images/icons8-copy-link-50.png" width="35s" height="35">' +
							'</div>'
						$('.shorter-result').html(html);
					},
					error: function (data) {
						console.log(errors);
						console.log(data);
					}
				});
			});
		});
    </script>
@endsection

