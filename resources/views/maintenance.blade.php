@extends('layouts.backend')

@section('content')
<div>
	@if (Session::has('message'))
	   <div class="alert alert-info">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('message-error'))
		<div class="alert alert-danger">{{ Session::get('message-error') }}</div>
	@endif
	<div class="card-body" style="padding-top:5%; padding-left:20%; padding-right:20%; padding-bottom:5%;">
		<form method="post" action="{{ action('MaintenanceController@PostMaintenance') }}" accept-charset="UTF-8">
			{{ csrf_field() }}
			@php
				$enablechecked = "";
				$disablechecked = "";
				$loadingmode = "";
				if($maintenance_mode == 2){
					$loadingmode = "checked=checked";
				}
				if($maintenance_mode == 1){
					$enablechecked = "checked=checked";
				}
				if($maintenance_mode == 0){
					$disablechecked = "checked=checked";
				}
			@endphp
			<div class="form-check form-check-inline">
				<input class="form-check-input" name="maintenance_mode" type="radio" id="enable" value="1" {{ $enablechecked }}>
				<label class="form-check-label" for="inlineCheckbox1">Maintenance Mode</label>
			</div>
			<div class="form-check form-check-inline">
				<input class="form-check-input" name="maintenance_mode" type="radio" id="loading_mode" value="2" {{ $loadingmode }}>
				<label class="form-check-label" for="inlineCheckbox2">Loading Mode</label>
			</div>
			<div class="form-check form-check-inline">
				<input class="form-check-input" name="maintenance_mode" type="radio" id="disable" value="0" {{ $disablechecked }}>
				<label class="form-check-label" for="inlineCheckbox2">Disable</label>
			</div>
			<div class="form-check form-check-inline">
				@if($id && !empty($id))
					<input type="hidden" name="id" value="{{ $id }}">
				@endif
				<button type="submit" class="btn btn-success">Update</button>
			</div>
		</form>
	</div>
</div>
@endsection
