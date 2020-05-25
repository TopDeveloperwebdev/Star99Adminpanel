@extends('layouts.admin')
@section('content')
<div class="content container">
    <div class="container-fluid">
        <div class="row">
            <div class="card w-100 mt-5">
                <div class="card-header">
                    Welcome
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <table class="table table-bordered table-striped draw-list">
                            <thead>
                                <tr class="">
                                    <th class="double-border">DATE</th>
                                    <th class="double-border">Round</th>
                                    <th>Total</th>
                                    <th> Bet Status</th>
                                    <th>Balance</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id='tbody'>

                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script>
    function renderPage(drawList) {
        var html = "";
        var date = new Object();
        Object.keys(drawList).forEach(function(rkey, row) {
            date[drawList[rkey]['bet_date']] = 0;
        });
        var parseTable = new Object();
        Object.keys(drawList).forEach(function(rkey, row) {
            parseTable[drawList[rkey]['bet_date'] + drawList[rkey]['round']] = {
                total: 0,
                status: 0,
                balance: 0,
                bet_date: drawList[rkey]['bet_date'],
                round: drawList[rkey]['round']
            };
        });
        var iRow = 0;
        var iRoud = 0;

        Object.keys(drawList).forEach(function(rkey, row) {
            var bettedNumbers = JSON.parse(drawList[rkey]['bettedNumbers']);
            var bettedAmount = JSON.parse(drawList[rkey]['bettedAmount']);
            var bettedBig = JSON.parse(drawList[rkey]['bettedBig']);
            var bettedSmall = JSON.parse(drawList[rkey]['bettedSmall']);
            var bettedEven = JSON.parse(drawList[rkey]['bettedEven']);
            var bettedOdd = JSON.parse(drawList[rkey]['bettedOdd']);
            var payout = JSON.parse(drawList[rkey]['payout']);
            var won = JSON.parse(drawList[rkey]['won']);
            var total = 0;
            var status = 0;
            var balance = 0;
            for (let i = 0; i < bettedNumbers.length; i++) {
                status += (bettedAmount[i] == null) ? 0 : bettedAmount[i];
                status += (bettedBig[i] == null) ? 0 : bettedBig[i];
                status += (bettedSmall[i] == null) ? 0 : bettedSmall[i];
                status += (bettedEven[i] == null) ? 0 : bettedEven[i];
                status += (bettedOdd[i] == null) ? 0 : bettedOdd[i];
                status -= (won[i] == '') ? 0 : Number(won[i]);
            }
            total = Number(drawList[rkey]['total']);
            date[drawList[rkey]['bet_date']] += 1;
            parseTable[drawList[rkey]['bet_date'] + drawList[rkey]['round']].total += total;
            parseTable[drawList[rkey]['bet_date'] + drawList[rkey]['round']].status += status;
        })
        let costItems = parseTable;
        Object.keys(costItems)
            .sort()
            .forEach(function(rkey, row) {
                html += '<tr>';
                if (iRow == 0) {
                    html += '<td  rowspan=' + date[costItems[rkey]['bet_date']] + '>';
                    html += costItems[rkey]['bet_date'];
                    html += '</td>'
                    iRow = date[costItems[rkey]['bet_date']];
                }
                iRow--;
                html += '<td>';
                html += costItems[rkey]['round'];
                html += '</td>';
                html += '<td >';
                html += costItems[rkey]['total'];
                html += '</td>'
                html += '<td >';
                html += (costItems[rkey]['status'] > 0 ? '+' : '-') + costItems[rkey]['status'];
                html += '</td>';
                html += '<td >';
                html += (costItems[rkey]['balance'] ? '$' : '') + costItems[rkey]['balance'];
                html += '</td>';
                html += '<td >';
                html += "<a class='btn btn-xs btn-primary' href=''> view </a>";
                html += '</td>';
                html += '</tr>';
            });

        $('#tbody').empty();
        $('#tbody').append(html);
    }

    window.onload = () => {
        var drawList = <?php echo json_encode($drawList); ?>;
        renderPage(drawList);
    }
</script>
@section('scripts')
@parent

@endsection
