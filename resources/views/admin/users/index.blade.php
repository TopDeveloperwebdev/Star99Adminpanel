@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('cruds.user.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="container">
        <form action="{{ route('admin.filterUsers') }}" method="POST">
            @csrf
            <div class="col-md-1">From</div>
            <div class='col-md-4'>
                <div class="form-group">
                    <div class='input-group date' id='datetimepicker6'>
                        <input type='text' class="form-control" name="sDate" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-1">To</div>
            <div class='col-md-4'>
                <div class="form-group">
                    <div class='input-group date' id='datetimepicker7'>
                        <input type='text' class="form-control" name="eDate" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-1">
                <input type="submit" class="btn btn-xs btn-primary" value="view" />
            </div>
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            DB S/N
                        </th>
                        <th>
                            Date Joined
                        </th>
                        <th>
                            UserID
                        </th>
                        <th>
                            Credits
                        </th>
                        <th>
                            Max Bet Limit
                        </th>
                        <th>
                            Max Day
                        </th>
                        <th>
                            State
                        </th>
                        <th>
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $key => $user)
                    <tr data-entry-id="{{ $user->id }}">
                        <td>

                        </td>
                        <td>
                            {{ $user->id ?? '' }}
                        </td>
                        <td>
                            {{ $user->created_at ?? '' }}
                        </td>
                        <td>
                            {{ $user->phone ?? '' }}
                        </td>

                        <td contenteditable="true" class="edittd" id="credit_{{$key}}" required>
                            {{ $user->credits ?? '' }}
                        </td>
                        <td contenteditable="true" class="edittd" id="max_bet_{{$key}}" required>
                            {{ $user->max_bet ?? '' }}
                        </td>
                        <td contenteditable="true" class="edittd" id="max_day_{{$key}}" required>
                            {{ $user->max_day ?? '' }}
                        </td>
                        <td>
                            {{ $user->status ? 'Activate' : 'Suspend'}}
                        </td>
                        <td>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                @if($user->status)
                                <input type="submit" class="btn btn-xs btn-danger" value='Ban'>
                                @else
                                <input type="submit" class="btn btn-xs btn-danger" value='Active'>
                                @endif
                            </form>

                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

    </div>
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a id='updateUsers' class="btn btn-success">
                Update
            </a>
        </div>
    </div>
</div>

@endsection
@section('scripts')
@parent
<script>
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
    @can('user_delete')
    let deleteButtonTrans = '{{ trans('
    global.datatables.delete ') }}'
    let deleteButton = {
        text: deleteButtonTrans,
        url: "{{ route('admin.users.massDestroy') }}",
        className: 'btn-danger',
        action: function(e, dt, node, config) {
            var ids = $.map(dt.rows({
                selected: true
            }).nodes(), function(entry) {
                return $(entry).data('entry-id')
            });

            if (ids.length === 0) {
                alert('zero_selected')

                return
            }

            if (confirm('are You Sure')) {
                $.ajax({
                        headers: {
                            'x-csrf-token': _token
                        },
                        method: 'POST',
                        url: config.url,
                        data: {
                            ids: ids,
                            _method: 'DELETE'
                        }
                    })
                    .done(function() {
                        location.reload()
                    })
            }
        }
    }
    dtButtons.push(deleteButton)
    @endcan

    $.extend(true, $.fn.dataTable.defaults, {
        order: [
            [1, 'desc']
        ],
        pageLength: 100,
    });
    $('.datatable-User:not(.ajaxTable)').DataTable({
        buttons: dtButtons
    })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
    $($.fn.dataTable.tables(true)).DataTable()
        .columns.adjust();
    });
    })
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
<script>
    $(function() {
        $('#datetimepicker6').click(function(e) {
            console.log(e);
        })
        $('#datetimepicker6').datetimepicker();
        $('#datetimepicker7').datetimepicker({
            useCurrent: false //Important! See issue #1075
        });
        $("#datetimepicker6").on("dp.change", function(e) {
            $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
        });
        $("#datetimepicker7").on("dp.change", function(e) {
            $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
        });
    });
</script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script>
    $("#updateUsers").click(function() {

        var users = <?php echo json_encode($users) ?>;
        Object.keys(users).forEach(function(key) {
            users[key]['max_bet'] = Number($("#credit_" + key).text());
            users[key]['max_day'] = Number($("#max_day_" + key).text());
            users[key]['credits'] = Number($("#max_bet_" + key).text());
        });
      console.log(users);
      var data = {
          users : users
      };
        $.ajax({
            method: "POST",
            headers: {
                Accept: "application/json"
            },
            url: "{{ route('admin.updateUsers') }}",
            data: data,
            success: () => {
                alert('Users are successfully edited!');
            },
            error: (response) => {
                alert('Try again please');
            }
        })


    });
</script>
@endsection
