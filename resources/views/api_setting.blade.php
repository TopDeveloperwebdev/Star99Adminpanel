@extends('layouts.backend')
@section('content')

<div style="display:none;" id="api_update" class="confirmation alert alert-success">
  <strong>API Updated!</strong>
</div>
<div style="display:none;" id="api_delete" class="confirmation alert alert-success">
  <strong>API Deleted!</strong>
</div>
<div style="display:none;" id="api_create" class="confirmation alert alert-success">
  <strong>API Created!</strong>
</div>

<div class="card-body" style="padding-top:5%; padding-left:20%; padding-right:20%; padding-bottom:5%;">
  <table id="api_table" class="table table-bordered table-striped text-center" style="background-color:white;table-layout: fixed;">
    <tbody id="api_table_tbody">
      <tr>
        <td contenteditable="false" style="background-color:#007bff;font-size: 20px;font-weight: bold;">Client ID</td>
        <td contenteditable="false" style="background-color:#007bff;font-size: 20px;font-weight: bold;">API Key</td>
        <td contenteditable="false" style="background-color:#007bff;font-size: 20px;font-weight: bold;">Delete</td>
      </tr>
    </tbody>
  </table>
  
</div>

<script>

  $( document ).ready(function() {
    $.post('api_getdata', {_token: '{{csrf_token()}}'}, function(data){
      for(var i = 0;i < data.length; i++){
        document.getElementById('api_table_tbody').innerHTML += '<tr id="tr_'+data[i].id+'"><td contenteditable="true" class="client_id">'+data[i].client_id+'</td><td contenteditable="true" class="api_key" required="">'+data[i].api_key+'</td><td contenteditable="false" required=""><button id=id_'+data[i].id+' class="btn btn-danger" onclick="deleteAPI(this)">Delete</button></td></tr>';
      }

      document.getElementsByClassName('card-body')[0].innerHTML += '<button onclick="update()" class="btn btn-primary">Update</button><br><table id="api_table" class="table table-bordered table-striped text-center" style="background-color:white;table-layout: fixed;"><tbody id="api_table_tbody"><tr><td contenteditable="false" style="background-color:#007bff;font-size: 20px;font-weight: bold;">Client ID</td><td contenteditable="false" style="background-color:#007bff;font-size: 20px;font-weight: bold;">API Key</td><td contenteditable="false" style="background-color:#007bff;font-size: 20px;font-weight: bold;">Create</td></tr><tr><td contenteditable="true" class="client_id" id="create_client_id"></td><td contenteditable="true" class="api_key" id="create_api_key"></td><td contenteditable="false"><button class="btn btn-primary" onclick="createAPI()">Create</button></td></tr></tbody></table>';

      $(".client_id").focusout(function(){
        val = $( this ).text();
        val = val.substr(-12, 12);
        $( this ).text(val);
      });

      $(".api_key").focusout(function(){
        val = $( this ).text();
        val = val.substr(-10, 10);
        $( this ).text(val);
      });
    });
  });

  function update(){
    $('.confirmation').css("display", "none");
    var api_data = [];
    
    for(var i=0;i < $('.client_id').length-1;i++){
      api_data.push({'client_id': $($('.client_id')[i]).html(), 'api_key' : $($('.api_key')[i]).html()});
    }

    $.post('api_update', {api_data, _token: '{{csrf_token()}}'}, function(data){
      $('#api_update').css("display", "block");
    });

  }

  function deleteAPI(q){
    var id = q.id.substring(3);
    $('.confirmation').css("display", "none");

    $.post('api_delete', {id, _token: '{{csrf_token()}}'}, function(data){
      $("#tr_" + id).css("display", "none");
      $('#api_delete').css("display", "block");
    });
  }

  function createAPI(){
    $('.confirmation').css("display", "none");
    var client_id = $('#create_client_id').html();
    var api_key = $('#create_api_key').html();

    $.post('api_create', {client_id, api_key, _token: '{{csrf_token()}}'}, function(data){
      $('#create_client_id').html('');
      $('#create_api_key').html('');
    });

    $.post('api_getdata', {_token: '{{csrf_token()}}'}, function(data2){
      $.post('api_getdata', {_token: '{{csrf_token()}}'}, function(data){
        console.log(data);
        document.getElementById('api_table_tbody').innerHTML = '<tr><td contenteditable="false" style="background-color:#007bff;font-size: 20px;font-weight: bold;">Client ID</td><td contenteditable="false" style="background-color:#007bff;font-size: 20px;font-weight: bold;">API Key</td><td contenteditable="false" style="background-color:#007bff;font-size: 20px;font-weight: bold;">Delete</td></tr>';
        for(var i = 0;i < data.length; i++){
          document.getElementById('api_table_tbody').innerHTML += '<tr id="tr_'+data[i].id+'"><td contenteditable="true" class="client_id">'+data[i].client_id+'</td><td contenteditable="true" class="api_key" required="">'+data[i].api_key+'</td><td contenteditable="false" required=""><button id=id_'+data[i].id+' class="btn btn-danger" onclick="deleteAPI(this)">Delete</button></td></tr>';
        }
      });
    });

    $('#api_create').css("display", "block");
  }
  
</script>

@endsection