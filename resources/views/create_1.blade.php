@extends('layouts.backend')

@section('content')
<div style="position: fixed; top: 2rem; right: 2rem; z-index: 9999999;">
    <!-- Toast message -->
    <div id="toast-message" class="toast fade hide" data-delay="4000" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header" style=>
            <i class="si si-bubble text-primary mr-2"></i>
            <strong class="mr-auto">Title</strong>
            <small class="text-muted">just now</small>
            <button type="button" class="ml-2 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="toast-body">
            This is a nice notification based on Bootstrap implementation.
        </div>
    </div>
    <!-- END Toast message-->

    <!-- Toast tofix-->
    <div id="toast-tofix" class="toast fade hide" data-delay="4000" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <i class="si si-wrench text-danger mr-2"></i>
            <strong class="mr-auto">System</strong>
            <small class="text-muted">just now</small>
            <button type="button" class="ml-2 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="toast-body">
            You must insert 4 number charactors
        </div>
    </div>
    <!-- END Toast tofix-->
</div>

     <div class="card" >
        <!--<form>-->
        @csrf
        <!--
        <div style="display:none;" id="createError" class="confirmation alert alert-danger">
        </div>
        -->
        <div style="display:none;" id="alreadyCreated" class="confirmation alert alert-danger">
        </div>
        <div class="card-body" id="cardCreateNumbers" style="padding-top:0%; padding-left:20%; padding-right:20%; padding-bottom:5%;">
            <h3 class=" text-center font-weight-bold text-uppercase py-4" style="padding-top:0%;">Create</h3>
            <div class="datatime" style="margin-bottom:3%;">
                    <button type="button" id="rand_button" class="btn btn-primary m-1" style="float:right; "><i class="fas fa-random"></i>Rand Numbers</button>
            </div>
                   <div id="table" class="table-editable table-responsive">
                      <table class="table table-bordered table-striped text-center" style="background-color:white;table-layout: fixed;">
                    <tbody>
                        <?php for($i = 1; $i < 4; $i++){?>
                        <tr>
                            <td contenteditable="false" colspan="2" id="ranking_<?php echo $i;?>"><?php echo $i;?></td>
                            <td contenteditable="true" colspan="3" class="edittd" id="number_<?php echo $i;?>" required></td>
                        </tr>
                        <?php }?>
                    </tbody>
                    <tbody>
                        <tr>
                        <td contenteditable="false" colspan="5" style="background-color:#007bff;font-size: 20px;font-weight: bold;">Special</td>
                        </tr>
                        <tr>
                        <?php for($i = 4; $i < 9; $i++){?>
                            <td contenteditable="true" class="edittd" id="number_<?php echo $i;?>" required></td>
                        <?php }?>
                        </tr>
                        <tr>
                        <?php for($i = 9; $i < 14; $i++){?>
                            <td contenteditable="true" class="edittd" id="number_<?php echo $i;?>" required></td>
                        <?php }?>
                        </tr>
                    </tbody>
                    <tbody>
                        <tr>
                        <td contenteditable="false" colspan="5" style="background-color:#007bff;font-size: 20px;font-weight: bold;">Consolation</td>
                        </tr>
                        <tr>
                        <?php for($i = 14; $i < 19; $i++){?>
                            <td contenteditable="true" class="edittd" id="number_<?php echo $i;?>" required></td>
                        <?php }?>
                        </tr>
                        <tr>
                        <?php for($i = 19; $i < 24; $i++){?>
                            <td contenteditable="true" class="edittd" id="number_<?php echo $i;?>" required></td>
                        <?php }?>
                        </tr>
                    </tbody>
                </table>
           
                <div class="text-center">
                    <button id="saveNumbers" class="btn btn-primary" style="font-size:20px;"><i class="far fa-file-alt"></i>&nbsp;&nbsp;Create</button>
                </div>
            </div> 
            
            <!--
              <div class="row items-push" style="margin-top:3%;">
            <div class="col-lg-7 offset-lg-5"style="margin-left:40%;">
                <button type="button" id="save_btn" class="btn btn-primary" style="font-size:20px;" data-toggle="modal" data-target="#modal-block-popout"><i class="far fa-file-alt"></i>&nbsp;&nbsp;&nbsp;Save</button>
            </div>
            -->
            <!-- <div id ="test2" >dddddd</div> -->
            
        </div>
  </div>
    <style>
      @media screen and (max-width: 507px) {
        #table{font-size:10px;}
        #cardCreateNumbers{padding:0 !important;}
      }
    </style>

    <script>
        $(document).ready(function () {
            $("#saveNumbers").click(function(){
              var values = {};
              var value = [];
              var wrongnumbers = false;
              for(var i=1; i<24; i++){
                val = $("#number_" + i).text();
                if(val.length == 0 || val == "----" ){wrongnumbers = true;}
                value.push({ranking: i, number: val});
              }

              if(wrongnumbers == true){
                alert("Please, fill all numbers.");
              } else {
                values['numbers'] = value;
                //console.log(values);

                $.post('createNewNumbers', {values, _token: '{{csrf_token()}}'}, function(data){
                  //window.open('http://95.217.73.101/?video=make2&itr=181', '_blank');
                  $('#saveNumbers').attr('disabled', 'true');
                  alert('Request is sent. Please, wait for 2 hours')
                  $.get('http://95.217.73.101?video=make2&itr=181', function(){
                    window.location.href = 'winnumbers';
                  });
                });
              }

              //console.log(value);
            });

            $("#rand_button").click(function(){
              var start_number = 1;
              for(var i=start_number;i<start_number+23;i++){
                  var rand_number = "" + Math.round(Math.random()*9999)
                  if(rand_number.length < 4){
                      while(rand_number.length < 4){
                          rand_number = "0"+rand_number;
                      }
                  }
                  $('#number_' + i).html(rand_number);
              }
            });

        $(".edittd").focusout(function(){
            val = $( this ).text();
            val = val.replace(/\D/g,'');
            if(val.length == 0){val = "0001"}
            console.log(val);
            if(val.length < 4){
                while(val.length < 4){
                    val = "0"+val;
                }
                $( this ).text(val);
            } else {
              val = val.substr(-4, 4);
              $( this ).text(val);
            }

        });

        $("#save_btn").click(function() {
            for (var i = 1; i < 24; i++) {
                var number = $('#number_' + i).text()
                if (!$.isNumeric(number) || number.length != 4) {
                    jQuery('#toast-tofix').toast('show');
                    $('#number_' + i).focus();
                    return false;
                }
            }
            jQuery('#modal-block-popout').modal('show');

        });
    });
    </script>

@endsection
