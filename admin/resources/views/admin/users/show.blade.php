@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.user.title') }}
    </div>

    <div class="card-body">
        <div class="mb-2">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            ID
                        </th>
                        <td>
                            {{ $user->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Phone
                        </th>
                        <td>
                            {{ $user->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Credits
                        </th>
                        <td>
                            {{ $user->credits }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Max Best
                        </th>
                        <td>
                            {{ $user->max_bet}}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Max Days
                        </th>
                        <td>
                            {{ $user->max_day ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            User state
                        </th>
                        <td>
                            {{ $user->status ?? '' }}
                        </td>
                    </tr>
                </tbody>

            </table>
            <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>


    </div>
</div>
@endsection
