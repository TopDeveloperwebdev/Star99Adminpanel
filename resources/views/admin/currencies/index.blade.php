@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('cruds.currency.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Currency">
                <thead>
                    <tr>
                        <th width="10">
                        </th>
                        <th>
                            Bet Type
                        </th>
                        <th>
                            payout
                        </th>
                        <th>
                            max_amount
                        </th>
                        <th>
                            difference
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($currencies as $key => $currency)
                    <tr data-entry-id="{{ $currency->id }}">
                        <td>

                        </td>
                        <td>
                            {{ $currency->bet_type ?? '' }}
                        </td>
                        <td>
                            {{ $currency->payout ?? '' }}
                        </td>
                        <td>
                            {{ $currency->max_amount ?? '' }}
                        </td>
                        <td>
                            {{ $currency->difference ?? '' }}
                        </td>
                        <td>
                            <a class="btn btn-xs btn-primary" href="{{ route('admin.currencies.show', $currency->id) }}">
                                {{ trans('global.view') }}
                            </a>
                            <a class="btn btn-xs btn-info" href="{{ route('admin.currencies.edit', $currency->id) }}">
                                {{ trans('global.edit') }}
                            </a>
                            <form action="{{ route('admin.currencies.destroy', $currency->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function() {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        @can('currency_delete')
        let deleteButtonTrans = '{{ trans('
        global.datatables.delete ') }}'
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.currencies.massDestroy') }}",
            className: 'btn-danger',
            action: function(e, dt, node, config) {
                var ids = $.map(dt.rows({
                    selected: true
                }).nodes(), function(entry) {
                    return $(entry).data('entry-id')
                });

                if (ids.length === 0) {
                    alert('{{ trans('
                        global.datatables.zero_selected ') }}')

                    return
                }

                if (confirm('{{ trans('
                        global.areYouSure ') }}')) {
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
        $('.datatable-Currency:not(.ajaxTable)').DataTable({
            buttons: dtButtons
        })
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
    })
</script>
@endsection
