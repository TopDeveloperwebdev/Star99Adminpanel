@extends('layouts.backend')

@section('content')
    <div style="position: fixed; top: 2rem; right: 2rem; z-index: 9999999;">
        <!-- Toast message -->
        <div id="toast-message" class="toast fade hide" data-delay="4000" role="alert" aria-live="assertive"
             aria-atomic="true">
            <div class="toast-header">
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
        <div id="toast-tofix" class="toast fade hide" data-delay="4000" role="alert" aria-live="assertive"
             aria-atomic="true">
            <div class="toast-header bg-city">
                <i class="si si-wrench mr-2"></i>
                <strong class="mr-auto"></strong>
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
    <?php if (!isset($no)) $no = 1;?>

    <div class="card">
        @csrf
        <div id="cardWinnumbers" class="card-body">
            @if ($message = Session::get('success'))
                <div class="confirmation alert alert-success alert-block">
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            <div style="display:none;" id="deleteSuccess" class="confirmation alert alert-success">
                <strong></strong>
            </div>
            <div style="display:none;" id="deleteError" class="confirmation alert alert-danger">
                <strong></strong>
            </div>
            <div style="display:none;" id="updateSuccess" class="confirmation alert alert-success">
                <strong></strong>
            </div>
            <div style="display:none;" id="updateError" class="confirmation alert alert-danger">
                <strong></strong>
            </div>
            <h3 class="text-center font-weight-bold py-4" style="padding-top:0%;">Server
                Time: {{ date('d-m-Y H:i') }}</h3>
            <div class="datatime" style="margin-bottom:0%;  text-align: center;">
                <div style="margin-bottom:5%;">
                    <input id="readd" type="date" value="{{!empty(end($data)->date)?end($data)->date:date('Y-m-d')}}"  style="background-color: #efefef; border-color:  #007bff;" disabled>
                    <input id="readt" type="time" value="{{!empty(end($data)->time)?end($data)->time:date('h:i')}}" style="background-color: #efefef; border-color: #007bff;" disabled>
                </div>
                <!--  
                <div>
                  <button type="button" id="clear_button" class="btn btn-primary m-1" data-toggle="modal" data-target="#modal-block-popout"><i class="fas fa-minus"></i>Check data</button>
                </div>
                -->
            </div>

            <div style="float:left;">
                {{--<button type="button" id="clear_button" class="btn btn-primary m-1" style="float:right; " data-toggle="modal" data-target="#modal-block-popout"><i class="fas fa-minus"></i>Delete Numbers</button>--}}
                <button type="button" onclick="createdate()" id="add_button" class="btn btn-primary m-1"
                        style="float:right; "><i class="fas fa-plus"></i>Create Draw
                </button>
                <button type="button" id="rand_button" class="btn btn-primary m-1" style="float:right; "><i
                            class="fas fa-random"></i>Rand Numbers
                </button>
            </div>

            <div id="table" class="table-editable table-responsive">
                <table class="table table-bordered table-striped text-center"
                       style="background-color:white;table-layout: fixed;">
                    <tbody>
                    <?php for($i = 1; $i < 4; $i++){?>
                    <tr>
                        <td contenteditable="false" colspan="2" id="ranking_{{$i}}">{{$i}}</td>
                        <td contenteditable="true" colspan="3" class="edittd" id="number_{{$i}}"
                            required>{{ !empty($data[$i-1])? str_pad($data[$i-1]->number, 4, '0', STR_PAD_LEFT) : '----' }}</td>
                    </tr>
                    <?php }?>
                    </tbody>
                    <tbody>
                    <tr>
                        <td contenteditable="false" colspan="5"
                            style="background-color:#007bff;font-size: 20px;font-weight: bold;">Special
                        </td>
                    </tr>
                    <tr>
                        <?php for($i = 4; $i < 9; $i++){?>
                        <td contenteditable="true" class="edittd" id="number_{{$i}}"
                            required>{{ !empty($data[$i-1])? str_pad($data[$i-1]->number, 4, '0', STR_PAD_LEFT) : '----' }}</td>
                        <?php }?>
                    </tr>
                    <tr>
                        <?php for($i = 9; $i < 14; $i++){?>
                        <td contenteditable="true" class="edittd" id="number_{{$i}}"
                            required>{{ !empty($data[$i-1])? str_pad($data[$i-1]->number, 4, '0', STR_PAD_LEFT) : '----' }}</td>
                        <?php }?>
                    </tr>
                    </tbody>
                    <tbody>
                    <tr>
                        <td contenteditable="false" colspan="5"
                            style="background-color:#007bff;font-size: 20px;font-weight: bold;">Consolation
                        </td>
                    </tr>
                    <tr>
                        <?php for($i = 14; $i < 19; $i++){?>
                        <td contenteditable="true" class="edittd" id="number_{{$i}}"
                            required>{{ !empty($data[$i-1])? str_pad($data[$i-1]->number, 4, '0', STR_PAD_LEFT) : '----' }}</td>
                        <?php }?>
                    </tr>
                    <tr>
                        <?php for($i = 19; $i < 24; $i++){?>
                        <td contenteditable="true" class="edittd" id="number_{{$i}}"
                            required>{{ !empty($data[$i-1])? str_pad($data[$i-1]->number, 4, '0', STR_PAD_LEFT) : '----' }}</td>
                        <?php }?>
                    </tr>
                    </tbody>
                </table>

                <div class="text-center">
                    <button id="updateNumbers" class="btn btn-primary" style="font-size:20px;"><i
                                class="far fa-file-alt"></i>&nbsp;&nbsp;Update
                    </button>
                </div>
                <!--
                <form id="upload_form" enctype="multipart/form-data" method="post">
                  <input class="my-2 ml-2" type="file" name="file1" id="file1"><br>
                  <input class="btn btn-primary ml-2" type="button" value="Upload File" onclick="uploadFile()">
                  <progress id="progressBar" value="0" max="100" style="width:300px;"></progress>
                  <h3 id="status"></h3>
                  <p id="loaded_n_total"></p>
                </form>
                -->
            </div>
        </div>


        <script>

            var is_passed = {!! $is_passed !!}  ;

            disableEdit();

            function disableEdit(){
                if (is_passed) {
                   $('.edittd').attr('contenteditable', 'false');
                }
            }

            function _(el) {
                return document.getElementById(el);
            }

            function uploadFile() {
                var file = _("file1").files[0];
                //alert(file.name+" | "+file.size+" | "+file.type);
                var formdata = new FormData();
                formdata.append("file1", file);

                var ajax = new XMLHttpRequest();
                ajax.upload.addEventListener("progress", progressHandler, false);
                ajax.addEventListener("load", completeHandler, false);
                ajax.addEventListener("error", errorHandler, false);
                ajax.addEventListener("abort", abortHandler, false);
                ajax.open("POST", "file_upload_parser.php");
                ajax.send(formdata);
            }

            function progressHandler(event) {
                _("loaded_n_total").innerHTML = "Uploaded" + event.loaded + " bytes of" + event.total;
                var percent = (event.loaded / event.total) * 100;
                _("progressBar").value = Math.round(percent);
                _("status").innerHTML = Math.round(percent) + "% uploaded... please wait.";
            }

            function completeHandler(event) {
                _("status").innerHTML = event.target.responseText;
                _("progressBar").value = 0;
            }

            function errorHandler(event) {
                _("status").innerHTML = "Upload Failed";
            }

            function abortHandler(event) {
                _("status").innerHTML = "Upload Aborted";
            }

            $("#updateNumbers").click(function () {
                var date = $("#readd").val();
                var date = $("#readd")[0].value;
                var time = $("#readt")[0].value;
                //var link = $("#link").val();
                var values = {};
                var value = [];
                for (var i = 1; i < 24; i++) {
                    val = $("#number_" + i).text();
                    if (val.length == 0) {
                        val = "0001"
                    }
                    value.push({ranking: i, number: val});
                }
                //console.log(value);
                values['numbers'] = value;
                values['date'] = date;
                values['time'] = time;
                //values['link'] = link;
                console.log(values);
                $.post('updateNumbers', {values, _token: '{{csrf_token()}}'}, function (data) {
                    $(".confirmation").css("display", "none");
                    if (data.success == "ok") {
                        $("#updateSuccess").css("display", "block").text('Numbers are successfully updated!');
                    } else {
                        $("#updateError").css("display", "block").text('No numbers at ' + values['date']);
                    }

                });
            });

            $("#clear_button").click(function () {
                var date = $("#readd").val();
                $.post('deleteNumbers', {date, _token: '{{csrf_token()}}'}, function (data) {
                    console.log(data);
                    $(".confirmation").css("display", "none");
                    if (data == 23) {
                        for (var i = 0; i < 23; i++) {
                            $('#number_' + (i + 1)).html('----');
                            $("#deleteSuccess").css("display", "block").text('Numbers are successfully deleted!');
                        }
                        //window.location.reload();
                    } else {
                        $("#deleteError").css("display", "block").text("Numbers already don't exist.");
                    }

                });

            });

            $("#readd").change(function () {
                $.post('postRequest', {date: this.value, _token: '{{csrf_token()}}'}, function (data) {
                    var newData = data['data'].reverse();
                    console.log(data);
                    if (newData.length > 0) {
                        console.log(newData);
                        $('#readt').val(data.data[0].time);
                        //$('#link').val(data.data[0].link);
                        for (var i = 0; i < newData.length; i++) {
                            var ranking = newData[i].ranking;
                            var needed_number = newData[(i)].number;
                            if (needed_number.length < 4) {
                                while (needed_number.length < 4) {
                                    needed_number = "0" + needed_number;
                                }
                            }
                            $('#number_' + (ranking)).html(needed_number);
                        }
                    } else {
                        $('#readt').val("----");
                        ///$('#link').val('----');
                        for (var i = 0; i < 23; i++) {
                            $('#number_' + (i + 1)).html('----');
                        }
                    }
                });
            });


            $("#rand_button").click(function () {
                var start_number = 1;
                for (var i = start_number; i < start_number + 23; i++) {
                    var rand_number = "" + Math.round(Math.random() * 9999)
                    if (rand_number.length < 4) {
                        while (rand_number.length < 4) {
                            rand_number = "0" + rand_number;
                        }
                    }
                    $('#number_' + i).html(rand_number);
                }
            });

            $(".edittd").focusout(function () {
                val = $(this).text();
                val = val.replace(/\D/g, '');
                if (val.length == 0) {
                    val = "0001"
                }
                console.log(val);
                if (val.length < 4) {
                    while (val.length < 4) {
                        val = "0" + val;
                    }
                    $(this).text(val);
                } else {
                    val = val.substr(-4, 4);
                    $(this).text(val);
                }

            });

            function createdate() {
                window.location = "createdate";
            }

            $("#save_btn").click(function () {
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


            $(document).ready(function () {
                $.post('selectMaxData', {_token: '{{csrf_token()}}'}, function (data) {

                    console.log(data);
                    $('#readd').val(data);
                    $.post('postRequest', {date: data, _token: '{{csrf_token()}}'}, function (data2) {
                        var newData = data2['data'].reverse();
                        if (newData.length > 0) {
                            console.log(newData);
                            $('#readt').val(data2.data[0].time);
                            //$('#link').val(data2.data[0].link);
                            for (var i = 0; i < newData.length; i++) {
                                var ranking = newData[i].ranking;
                                var needed_number = newData[(i)].number;
                                if (needed_number.length < 4) {
                                    while (needed_number.length < 4) {
                                        needed_number = "0" + needed_number;
                                    }
                                }
                                $('#number_' + (ranking)).html(needed_number);
                            }
                        } else {
                            $('#readt').val("----");
                            for (var i = 0; i < 23; i++) {
                                $('#number_' + (i + 1)).html('----');
                            }
                        }
                    });

                });

            });

            /*
              $('#ajaxSubmit').click(function(e){
                  e.preventDefault();
                  var Data = new Array();
@if(count($data)>0)
            var start_number = {{end($data)->id}};
            @else
            var start_number = 1;
@endif

            for(var i=start_number;i<start_number+23;i++){
                var number = $('#number_' + i).text()
                if(!$.isNumeric(number) || number.length != 4){
                    jQuery('#toast-tofix').toast('show');
                    $('#number_' + i).focus();
                    return false;
                }
                Data.push({
                    id: i,
                    ranking: $('#ranking_' + i).text(),
                    number: $('#number_' + i).text()
                });
            }
            
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "/store",
                method: 'post',
                data: {
                        _token : $('meta[name="csrf-token"]').attr('content'),
                        data: Data,
                        date: $('#readd').val(),
                        time: $('#readt').val()
                },
                datatype: 'JSON',
                success: function(data) { 
                    alert(data);
                }
            });

        }); 
        $('#del_button').click(function(e){
            e.preventDefault();
            var Data = new Array();
            @if(count($data)>0)
            var start_number = {{end($data)->id}};
            @else
            var start_number = 1;
@endif

            for(var i=start_number;i<start_number+23;i++){
                
                Data.push({
                    id: i
                });
            }
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "/delete",
                method: 'post',
                data: {
                        _token : $('meta[name="csrf-token"]').attr('content'),
                        data: Data
                },
                datatype: 'JSON',
                success: function(data) { 
                    alert(data);
                    window.location="winnumbers";
                }
            });
    });*/
        </script>


@endsection
