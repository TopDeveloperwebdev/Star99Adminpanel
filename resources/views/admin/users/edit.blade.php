@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.user.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.users.update", [$user->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                <label for="name">Phone *</label>
                <input type="phone" id="phone" name="phone" class="form-control" value="{{ old('phone', isset($user) ? $user->phone : '') }}" required>
                @if($errors->has('phone'))
                <p class="help-block">
                    {{ $errors->first('phone') }}
                </p>
                @endif
            </div>
            <div class="form-group {{ $errors->has('credits') ? 'has-error' : '' }}">
                <label for="name">Credits *</label>
                <input type="number" id="credits" name="credits" class="form-control" value="{{ old('credits', isset($user) ? $user->credits : '') }}" required>
                @if($errors->has('credits'))
                <p class="help-block">
                    {{ $errors->first('credits') }}
                </p>
                @endif
            </div>
            <div class="form-group {{ $errors->has('max_bet') ? 'has-error' : '' }}">
                <label for="name">Max bet *</label>
                <input type="number" id="max_bet" name="max_bet" class="form-control" value="{{ old('max_bet', isset($user) ? $user->max_bet : '') }}" required>
                @if($errors->has('max_bet'))
                <p class="help-block">
                    {{ $errors->first('max_bet') }}
                </p>
                @endif
            </div>
            <div class="form-group {{ $errors->has('max_day') ? 'has-error' : '' }}">
                <label for="name">Max Days *</label>
                <input type="number" id="max_day" name="max_day" class="form-control" value="{{ old('max_day', isset($user) ? $user->max_day : '') }}" required>
                @if($errors->has('max_day'))
                <p class="help-block">
                    {{ $errors->first('max_day') }}
                </p>
                @endif
            </div>
            <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                <label for="name">User Status*</label>
                <input type="number" id="status" name="status" class="form-control" value="{{ old('status', isset($user) ? $user->status : '') }}" required>
                @if($errors->has('status'))
                <p class="help-block">
                    {{ $errors->first('status') }}
                </p>
                @endif
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="save">
            </div>
        </form>


    </div>
</div>
@endsection
