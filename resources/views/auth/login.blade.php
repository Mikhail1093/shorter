@extends('layouts.app')

@section('content')
    <div class="flex-center position-ref full-height not-auth-shorter-form">
        <div class="content">
            <div class="col-12" style="background-color: #ffffff; padding: 15px">
                <div class="col-md-12 shorter-result">

                </div>
                {{--todo action="/ajax/short-link"  переделать на имя роута--}}

                <form id="login-form" class="form-inline" action="/ajax/short-link" method="post" role="form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group mb-12" style="width: 50%">
                        <input type="text" name="link" id="link" tabindex="1" class="form-control"
                               placeholder="http://site.ru" value="" style="width: 100%; margin-right: 10px">

                    </div>
                    <div class="form-group mb-3 right-col" style="margin-top: 15px">
                        <img src="{{ captcha_src() }}" alt="captcha" class="captcha-img" data-refresh-config="default"
                             style="margin-right: 10px">
                        <a style="margin-right: 10px" href="#" id="refresh">
                            <span class="glyphicon glyphicon-refresh">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
    <path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"/>
    <path d="M0 0h24v24H0z" fill="none"/>
</svg>
                            </span></a></p>
                        <input class="form-control" type="text" name="captcha" style="width: 18%; margin-right: 10px"/>

                        <input type="button" name="short-link" class="btn btn-primary "
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
				var captcha = $('input[name="captcha"]').val();

				$.ajax({
					type: 'post',
					url: '/ajax/short-link',
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					data: {
						link: link,
						captcha: captcha
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
						//todo если ошибка, то очишать поле капчи
						if('undefined' !== data.responseJSON.errors.captcha[0]) {
                            $('.shorter-result').html('<div class="alert alert-danger"><strong>Error! </strong>' + data.responseJSON.errors.captcha[0] + '</div>');
                        }
					}
				});
			});

			$('#refresh').on('click', function () {
				var captcha = $('img.captcha-img');
				var config = captcha.data('refresh-config');
				$.ajax({
					method: 'GET',
					url: '/get_captcha/' + config,
				}).done(function (response) {
					captcha.prop('src', response);
				});
			});

		});
    </script>
@endsection

