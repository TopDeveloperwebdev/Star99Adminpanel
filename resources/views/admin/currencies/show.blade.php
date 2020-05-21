@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.currency.title') }}
    </div>

    <div class="card-body">
        <div class="mb-2">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            Bet_type
                        </th>
                        <td>
                            {{ $currency->bet_type ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Payout
                        </th>
                        <td>
                            {{ $currency->payout ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Max_amount
                        </th>
                        <td>
                            {{ $currency->max_amount ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Difference
                        </th>
                        <td>
                            {{ $currency->difference ?? '' }}
                        </td>
                    </tr>

                </tbody>
            </table>
            <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>

        <nav class="mb-3">
            <div class="nav nav-tabs">

            </div>
        </nav>
        <div class="tab-content">

        </div>
    </div>
</div>
@endsection
