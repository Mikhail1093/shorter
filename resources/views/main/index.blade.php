@extends('layouts.app')

@section('content')
    {{--<div id="app1">
        <example-component :testdata="{{ json_encode($test) }}"></example-component>
    </div>
    <test-component></test-component>--}}

    <div class="flex-center position-ref full-height">
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
                        <input type="button" name="short-link" style="margin-top: -5px" class="btn btn-primary " value="Сократить">
                    </div>
                </form>
            </div>
        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete link {link_url}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal-body-dialog-link-data">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="delete_link" type="button" class="btn btn-primary delete_link">Delete link</button>
                </div>
            </div>
        </div>
    </div>
    <div class="">
        <div class="col-9" style="margin-top: 14px;">
            <div class="table-responsive">
                <table id="mytable" class="table table-bordred table-striped">
                    <thead>
                    <th><input type="checkbox" id="checkall"/></th>
                    <th>Original URL</th>
                    <th>Date create</th>
                    <th>Short URL</th>
                    <th>Click count</th>
                    <th>Statistic</th>
                    </thead>

                    <tbody>
                    @foreach($links_data as $links_data)
                        <tr>
                            <td>
                                <ul class="navbar-nav mr-auto">

                                </ul>
                                <ul class="navbar-nav ml-auto">
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle-links" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre="">
                                        ...
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a data-toggle="modal"
                                           data-target="#exampleModal"
                                           href="#"
                                           data-value="{{ route('delete.link', ['short_code' => $links_data['short_url']]) }}"
                                           class="dropdown-item delete-link-action">
                                            delete
                                        </a>
                                    </div>
                                </li>
                                </ul>
                            </td>
                            <td>
                                <a target="_blank"
                                   title="{{ $links_data['initial_url'] }}"
                                   href="{{ $links_data['initial_url'] }}"
                                >
                                    {{ str_limit($links_data['initial_url'], $limit = 50, $end = '...') }}
                                </a>
                            </td>
                            <td>{{ $links_data['created_at'] }}</td>
                            <td>
                                <a href="shorter.loc/{{ $links_data['short_url'] }}">
                                    shorter.loc/{{ $links_data['short_url'] }}
                                </a>
                            </td>
                            <td>{{ $links_data['redirect_count'] }}</td>
                            <td><a target="_blank" href="/statistic/{{ $links_data['short_url'] }}">statistic</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
			/**
			 * Скопировать ссылку
			 */
			$(document).on('click', '.copy-link-icon', function () {
				$('.data-link').text().execCommand('copy');
			});

			/**
             * подствить в popup данные о ссылке
			 */
			$(document).on('click', '.delete-link-action', function () {
				var link = $(this).attr('data-value');

				$('#delete_link').attr('data-value', link);

			});

			/**
             * Удалить ссылку
			 */
			$(document).on('click', '#delete_link', function () {
				var link = $(this).attr('data-value');

				console.log(link);
				$.ajax({
					type: 'post',

					url: link,
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					data: {
						_method: 'DELETE'
					},
					success: function (data) {
						console.log(data);
						console.log(data['result_code']);

						if(data['result_code'] === 1) {
							$('.modal-body-dialog-link-data').html('<div class="alert alert-success">Link has been removed</div>');
                        }
					},
					error: function (data) {
						//todo обработка если проблемы
					}
				});
			});

			/**
             * Сократить ссылку
			 */
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
@endsection()
