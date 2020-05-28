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
                            Payout
                        </th>
                        <th>
                            Max Bet
                        </th>
                        <th>
                            Difference %
                        </th>
                        <th>
                            Updated_at
                        </th>
                        <th>

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
                            {{ $currency->updated_at ?? '' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>
    </div>
</div>
@endsection
