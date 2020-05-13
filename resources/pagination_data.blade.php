<div class="table-editable">
                <table class="table table-bordered table-responsive-md table-striped text-center" style="background-color:white;">
                    <thead style="background-color:#5c80d1;">
                        <tr>
                            <th class="text-center">NO</th>
                            <th class="text-center">Ranking</th>
                            <th class="text-center editer">WinNumbers</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $row)
                        <tr>
                            <td contenteditable="false"><?php echo $no++;?></td>
                            <td contenteditable="false" id="ranking_{{$row->ranking}}">{{$row->ranking}}</td>
                            <td contenteditable="true" id="number_{{$row->ranking}}">{{$row->number}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $data->links() }}
</div>