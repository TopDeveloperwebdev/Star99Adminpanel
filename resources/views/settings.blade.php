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
    <p class="mb-0"><strong>Server Date:</strong> {{date('Y-m-d')}}</p>
    <p><strong>Server Time:</strong> {{date('H:i:s')}}</p>

    <select class="form-control" id="timezone_change" style="display: inline-block; width: auto;">
    <option value="Pacific_Midway">GMT-11</option>
      <option value="US_Hawaii">GMT-10</option>
      <option value="Pacific_Gambier">GMT-9</option>
      <option value="US_Alaska">GMT-8</option>
      <option value="US_Arizona">GMT-7</option>
      <option value="America_Mazatlan">GMT-6</option>
      <option value="US_Central">GMT-5</option>
      <option value="US_Eastern">GMT-4</option>
      <option value="Atlantic_Stanley">GMT-3</option>
      <option value="America_Godthab">GMT-2</option>
      <option value="Etc_GMT+1">GMT-1</option>
      <option value="Atlantic_Azores">GMT-0</option> 
      <option value="Europe_London">GMT+1</option>
      <option value="Europe_Amsterdam">GMT+2</option>
      <option value="Asia_Kuwait">GMT+3</option>
      <option value="Asia_Baku">GMT+4</option>
      <option value="Asia_Karachi">GMT+5</option>
      <option value="Asia_Dhaka">GMT+6</option>
      <option value="Asia_Bangkok">GMT+7</option>
      <option value="Asia_Singapore">GMT+8</option>
      <option value="Asia_Tokyo">GMT+9</option>
      <option value="Australia_Hobart">GMT+10</option>
      <option value="Asia_Magadan">GMT+11</option>
      <option value="Pacific_Fiji">GMT+12</option>
    </select>
    <button class="btn btn-primary m-1 mb-2" onclick="window.location=window.location.href.substring(0, window.location.href - 8)+'changeTimezone/'+document.getElementById('timezone_change').value">Change Timezone</button>

    <p><strong>Email Address:</strong> {{ Auth::user()->email }}</p>

    <p><strong>Set Default Time:</strong></p>
    <div id="msg"></div>
    <p>
      <input type="hidden" name="setting_id" id="setting_id" value="{{ $setting_id }}">
      <input type="hidden" name="csrfToken" value="{{ csrf_token() }}">    
      <input class="form-control" id="defaultTime" name="defaultTime" type="time" value="{{ date('H:i:s' , strtotime($defaulttime)) }}" style="display: inline-block; width: auto;">
      <button type="submit" class="btn btn-primary m-1 mb-2" id="save-default-time">Save</button>
    </p>

    <a href="changeEmail">Change email</a><br>
    <a href="changePassword">Change password</a><br>
    <a href="fillCalendar">Fill Calendar</a>
  </div>
</div>
<script>
  var timezoneValue = '{{env('APP_TIMEZONE')}}';
  var tzFormat = timezoneValue.replace('/', '_');
  console.log(tzFormat);
  ($("option[value='"+tzFormat+"']")[0].selected = true);

  $('#loading_indicator').on('change',function() {
    var value = 0;
    if(this.checked){
      var value = 1;
    }
    var token =  $('input[name="csrfToken"]').attr('value'); 
    $.ajax({
      type: "POST",
      url: "{{ action('WinnumbersController@PostLoadingIndicator') }}",
      data: {loading_indicator:value},
      headers: {
          'X-CSRF-Token': token 
      },
      success: function(data) {
          
      }
    });
  });

  $('#save-default-time').on('click',function() {
    var setting_id =  $('#setting_id').val();
    var token =  $('input[name="csrfToken"]').attr('value'); 
    var defaultTime =  $('#defaultTime').val();
    $.ajax({
      type: "POST",
      url: "{{ action('MaintenanceController@PostDefaultTimeSetting') }}",
      data: {id:setting_id,defaultTime:defaultTime},
      headers: {
          'X-CSRF-Token': token 
      },
      success: function(response) {
          $("#msg").html('');
          if(!response.error){
            $("#msg").html('<div class="alert alert-success">'+response.msg+'</div>');                        
          }else{
            $("#msg").html('<div class="alert alert-error">Something went wrong please try again!!</div>');
          }
          setTimeout(function(){ 
            $("#msg").html('');
          }, 3000);
      }
    }); 
  });
</script>

@endsection
