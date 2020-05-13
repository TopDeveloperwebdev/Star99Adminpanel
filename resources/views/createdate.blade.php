@extends('layouts.backend')

@section('content')

    <br/>
    <div id="cardWinnumbers" class="table-editable table-responsive">
        <button type="button" id="rand_button" class="btn btn-primary m-1" style="float:right; "><i class="fas fa-random"></i>Rand Numbers</button>
        <div class="ml-2 mt-2 mb-2 text-center">
            <input id="readd" type="date"  value="{{date('Y-m-d')}}" style="background-color: #efefef; border-color:  #007bff;">
            <input id="readt" type="time" value="{{date('H:i:s', strtotime($defaulttime))}}" style="background-color: #efefef; border-color: #007bff;">
        </div>
        <br/>
        <table class="table table-bordered table-striped text-center"
               style="background-color:white;table-layout: fixed;">

            <tbody>
            <tr>
                <td contenteditable="false" colspan="2" id="ranking_1">1</td>
                <td contenteditable="true" colspan="3" class="edittd" id="number_1" required=""></td>
            </tr>
            <tr>
                <td contenteditable="false" colspan="2" id="ranking_2">2</td>
                <td contenteditable="true" colspan="3" class="edittd" id="number_2" required=""></td>
            </tr>
            <tr>
                <td contenteditable="false" colspan="2" id="ranking_3">3</td>
                <td contenteditable="true" colspan="3" class="edittd" id="number_3" required=""></td>
            </tr>
            </tbody>
            <tbody>
            <tr>
                <td contenteditable="false" colspan="5"
                    style="background-color:#007bff;font-size: 20px;font-weight: bold;">Special
                </td>
            </tr>
            <tr>
                <td contenteditable="true" class="edittd" id="number_4"></td>
                <td contenteditable="true" class="edittd" id="number_5"></td>
                <td contenteditable="true" class="edittd" id="number_6"></td>
                <td contenteditable="true" class="edittd" id="number_7"></td>
                <td contenteditable="true" class="edittd" id="number_8"></td>
            </tr>
            <tr>
                <td contenteditable="true" class="edittd" id="number_9"></td>
                <td contenteditable="true" class="edittd" id="number_10"></td>
                <td contenteditable="true" class="edittd" id="number_11"></td>
                <td contenteditable="true" class="edittd" id="number_12"></td>
                <td contenteditable="true" class="edittd" id="number_13"></td>
            </tr>
            </tbody>
            <tbody>
            <tr>
                <td contenteditable="false" colspan="5"
                    style="background-color:#007bff;font-size: 20px;font-weight: bold;">Consolation
                </td>
            </tr>
            <tr>
                <td contenteditable="true" class="edittd" id="number_14"></td>
                <td contenteditable="true" class="edittd" id="number_15"></td>
                <td contenteditable="true" class="edittd" id="number_16"></td>
                <td contenteditable="true" class="edittd" id="number_17"></td>
                <td contenteditable="true" class="edittd" id="number_18"></td>
            </tr>
            <tr>
                <td contenteditable="true" class="edittd" id="number_19"></td>
                <td contenteditable="true" class="edittd" id="number_20"></td>
                <td contenteditable="true" class="edittd" id="number_21"></td>
                <td contenteditable="true" class="edittd" id="number_22"></td>
                <td contenteditable="true" class="edittd" id="number_23"></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="text-center">
        <button onclick="create_date();" class="btn btn-primary ml-2">Create Numbers</button>
    </div>

    <script>
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
                val = "";
            } else {
                if (val.length < 4) {
                    while (val.length < 4) {
                        val = "0" + val;
                    }
                } else {
                    val = val.substr(-4, 4);
                }
            }
            $(this).text(val);
        });

        function create_date() {
            var date = $('#readd').val();
            var time = $('#readt').val();
            $.post('createdatecheck', {date, _token: '{{csrf_token()}}'}, function (data) {
                console.log(data);
                if (data == '1') {
                    alert('Numbers at this date are already created!');
                } else {
                    var values = {};
                    var value = [];
                    var wrongnumbers = false;
                    for (var i = 1; i < 24; i++) {
                        val = $("#number_" + i).text();
                        if (val.length == 0 || val == "----") {
                            wrongnumbers = true;
                        }
                        value.push({ranking: i, number: val});
                    }
                    if (wrongnumbers == true) {
                        alert('Please, fill all numbers.');
                    } else {
                        $.post('adddate', {value, date, time, _token: '{{csrf_token()}}'}, function (data2) {
                            console.log(data2);
                            if (data2.is_ealier) {
                                alert('Please select date/time after current date/time.');
                            } else {
                                window.location.href = 'dashboard';
                            }
                        });
                    }
                }
            });
        }
    </script>

@endsection
