<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Winnumber;
use App\Configuration;
use App\Models\FillModel;
use DB;
use Illuminate\Support\Facades\Redirect;

class WinnumbersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application winnumber page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($data = null)
    {
        $getData = DB::table('winnumbers')->where('is_draw', 1)->orderBy('id', 'desc')->paginate(23);
        $latest_record = DB::table('winnumbers')->where('is_draw', 1)->orderBy('id', 'desc')->first();
        $date_time = $latest_record->date . " " . $latest_record->time;
        $now = date('Y-m-d H:i:s');

        $is_passed = $now > $date_time ? 1 : 0;

        $data = array_reverse($getData->toArray()['data']);
        return view('winnumbers', ['data' => $data, 'is_passed' => $is_passed]);
    }

    public function settings()
    {
        $setting = DB::table('setting')->first(); 
        $data['defaulttime'] = $setting->defaulttime;
        $data['setting_id'] = $setting->id;        
        return view('settings', $data);
    }

    public function api_setting()
    {
        return view('api_setting');
    }

    public function viewLog(Request $request)
    {
        $log_file = public_path('/log/') . 'api.log';
        $content = file_get_contents($log_file);
        return view('view_log', ['log_content' => $content]);

    }

    public function api_getdata(Request $request)
    {
        if ($request->ajax()) {
            return $data = DB::table('api')->get();
        }
    }


    public function api_update(Request $request)
    {
        if ($request->ajax()) {
            //INSERT INTO `api`(`client_id`, `api_key`) VALUES ([value-1],[value-2])
            $query = 'INSERT INTO api(client_id, api_key) VALUES ';
            foreach ($request->api_data as $data) {
                $query .= "('" . $data['client_id'] . "','" . $data['api_key'] . "'),";
            }
            $query = rtrim($query, ',');

            DB::table('api')->truncate();
            DB::statement($query);

            return $query;

            //return $request->api_data;
        }
    }

    public function api_delete(Request $request)
    {
        if ($request->ajax()) {
            DB::table('api')->where('id', '=', $request->id)->delete();
            return $request->id;
        }
    }

    public function api_create(Request $request)
    {
        if ($request->ajax()) {
            DB::table('api')->insert(
                ['client_id' => $request->client_id, 'api_key' => $request->api_key]
            );
        }
    }

    public function fetch_data(Request $request)
    {
        if ($request->ajax()) {
            return $data = DB::table('winnumbers')->where('date', $request->date)->orderBy('id', 'desc')->paginate(23);
            //return view('winnumbers', compact('data'));
        }
    }

    public function createNewNumbers(Request $request)
    {
        if ($request->ajax()) {
            /*
            $data = DB::table('winnumbers')->select('draw')->orderBy('id', 'desc')->take(1)->get();
            $getDraw = preg_replace('/[^0-9]/', '', json_encode($data[0]));
            $draw = $getDraw + 1;
            */
            $log_file = public_path('/log/') . 'api.log';
            $myfile = fopen($log_file, "a") or die("Unable to open file!");
            $log_content = date("d-m-Y H:i:s") . "\t" . json_encode($request->values['numbers']);
            fwrite($myfile, "\n" . $log_content);
            fclose($myfile);

            foreach ($request->values['numbers'] as $row) {

                DB::table('winnumbers')->insert(
                    array(
                        'ranking' => $row['ranking'],
                        'number' => $row['number'],
                        //'link'     =>   ' ',
                        'date' => null,
                        'time' => null,
                        'created_at' => now(),
                    )
                );

            }

            session(['numbers' => $request->values['numbers']]);

        }
    }

    public function allowCreateVideo(Request $request)
    {
        if ($request->ajax()) {
            $now = date('Y-m-d H:i:s');
            $last_record = DB::table('winnumbers')->orderBy('created_at', 'DESC')->first();
            $previous_last_time = strtotime($last_record->created_at);
            $difference = (strtotime($now) - $previous_last_time) / 3600;
            $difference_min = 120 - (strtotime($now) - $previous_last_time) / 60;
            $status = $difference > 2 ? "1" : "0";

            return response()->json(['status' => $status, 'diff' => $difference_min]);
        } else {
            return response()->json(['status' => '0']);
        }
    }

    public function createdate(Request $requset)
    {
        $setting = DB::table('setting')->first(); 
        $data['defaulttime'] = $setting->defaulttime;    
        return view('createdate', $data);
    }

    public function createdatecheck(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('winnumbers')->where('date', $request->date)->exists();
            return $data ? "1" :"0";
        }
    }

    public function adddate(Request $request)
    {
        if ($request->ajax()) {

            $request_datetime = $request->date . " " . $request->time;
            $now = date('Y-m-d H:i:s');
            if ($now > $request_datetime) {
                return response()->json(['is_ealier' => '1']);
            } else {
                foreach ($request->value as $row) {
                    DB::table('winnumbers')->insert(
                        array(
                            'ranking' => $row['ranking'],
                            'number' => $row['number'],
                            'date' => $request->date,
                            'time' => $request->time,
                            'is_draw' => 1,
                            'created_at' => now(),
                        )
                    );
                }
            }
        }
    }

    public function deleteNumbers(Request $request)
    {
        if ($request->ajax()) {

            //DB::table('winnumbers')->where('date', $request->date)->delete();
            $query = DB::table('winnumbers')->where('date', $request->date)->delete();
            return $query;
        }
    }

    public function updateNumbers(Request $request)
    {
        if ($request->ajax()) {

            $count = DB::table('winnumbers')->where('date', $request->values['date'])->count();
            if ($count == 23) {

                $numberDate = $request->values['date'];
                $numberTime = $request->values['time'];
                $ranking = 1;

                foreach ($request->values['numbers'] as $row) {
                    DB::table('winnumbers')->where([['date', $numberDate], ['ranking', $ranking]])
                        ->update(
                            array(
                                'number' => $row['number'],
                                'time' => $numberTime,
                                //'link' => $request->values['link'],
                                'updated_at' => now()
                            )
                        );

                    $ranking++;
                }
                return response()->json(['success' => 'ok']);
            } else {
                return response()->json(['success' => 'error']);
            }

        }
    }

    public function selectMaxData(Request $request)
    {
        if ($request->ajax()) {
            return $data = DB::table('winnumbers')->max('date');
        }
    }

    public function create()
    {
        // $data['winnumbers'] = Winnumber::get();
        return view('create');
    }

    public function store(Request $request)
    {
        // echo "asdfasdf";
        $data = $request['data'];
        //saving data
        foreach ($data as $row) {
            $winnumber = Winnumber::find($row['id']);
            $winnumber->ranking = $row['ranking'];
            $winnumber->number = $row['number'];
            $winnumber->date = $request['date'];
            $winnumber->time = $request['time'];
            $winnumber->save();
        }

        //saving date time
        $config = new Configuration;
        $config->ranking_count = 23;
        $config->date = $request['date'];
        $config->time = $request['time'];
        $config->save();
        $data['date'] = $config->date;
        $this->index($data);
        return response()->json(['Data is successfully Updated!']);
    }


    public function add(Request $request)
    {


        $data = $request['data'];
        // var_dump($data);exit();
        //saving data
        foreach ($data as $row) {

            // $winnumber = Winnumber::find($row['ranking']);
            $winnumber = new Winnumber;
            $winnumber->ranking = $row['ranking'];
            $winnumber->number = $row['number'];
            $winnumber->date = $request['date'];
            $winnumber->time = $request['time'];
            $winnumber->save();

        }

        //saving date time

        $config = new Configuration;
        $config->ranking_count = 23;
        $config->date = $request['date'];
        $config->time = $request['time'];
        $config->save();


        return response()->json(['Data is successfully Created!']);
    }

    public function delete(Request $request)
    {
        $data = $request['data'];
        // var_dump($data);
        foreach ($data as $row) {
            $winnumber = Winnumber::find($row['id']);
            $winnumber->delete();
        }
        return response()->json(['winnumber deleted successfully']);
    }


    public function fillCal()
    {
        $FillModel = new FillModel();
        $FillModel->fillCal();
        return Redirect::back();
    }

    public function PostLoadingIndicator(Request $request){
        DB::table('setting')->where("id", 2)->update(["loading_indicator" => $request->get('loading_indicator')]);
    }


}
