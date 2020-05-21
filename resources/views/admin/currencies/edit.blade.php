@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ $currency->bet_type }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.currencies.update", [$currency->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('payout') ? 'has-error' : '' }}">
                <label for="payout">Payout*</label>
                <input type="text" id="payout" name="payout" class="form-control" value="{{ old('payout', isset($currency) ? $currency->payout : '') }}" required>
                @if($errors->has('payout'))
                <p class="help-block">
                    {{ $errors->first('payout') }}
                </p>
                @endif

            </div>
            <div class="form-group {{ $errors->has('max_amount') ? 'has-error' : '' }}">
                <label for="max_amount">Max Betting Amount*</label>
                <input type="number" id="max_amount" name="max_amount" class="form-control" value="{{ old('max_amount', isset($currency) ? $currency->max_amount : '') }}" required>
                @if($errors->has('max_amount'))
                <p class="help-block">
                    {{ $errors->first('max_amount') }}
                </p>
                @endif
            </div>

            <div class="form-group {{ $errors->has('difference') ? 'has-error' : '' }}">
                <label for="difference">Difference *</label>
                <input type="number" id="difference" name="difference" class="form-control" value="{{ old('difference', isset($currency) ?  $currency->difference  : '') }}" required>
                @if($errors->has('difference'))
                <p class="help-block">
                    {{ $errors->first('difference') }}
                </p>
                @endif
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>


    </div>
</div>
@endsection
