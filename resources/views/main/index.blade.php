@extends('layouts.main')


@section('content')
    <div class="flex-center position-ref full-height">
        <div class="content">
            <div class="col-12" style="background-color: #ffffff; padding: 15px">
                <form id="login-form" action="/ajax/short-link" method="post" role="form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <input type="text" name="link" id="link" tabindex="1" class="form-control col-6"
                               placeholder="http://site.ru" value="" style="display: inline">
                        <input type="button" name="short-link" class="btn btn-primary" value="Сократить">
                    </div>
                </form>
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
                            <td><input type="checkbox" class="checkthis"/></td>
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
				},
				error: function (data) {
					console.log(errors);
					console.log(data);
				}
			});
		});

    </script>
@endsection()
