@extends('layouts.backend')
@section('content')
    <div class="card-body" style="padding-top:5%; padding-left:20%; padding-right:20%; padding-bottom:5%;">
        <textarea style="width:100%; height: 900px" readonly>{{ $log_content }}</textarea>
    </div>
@endsection