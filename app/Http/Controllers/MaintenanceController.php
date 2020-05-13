<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Http\Request;
use DB;

class MaintenanceController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('home');
    }

    public function showMaintenanceForm(){
    	$maintenance = DB::table('setting')->first();
    	$main_mode = '2';
    	$id = 0;
    	if($maintenance && !empty($maintenance)){
    		$main_mode = $maintenance->maintenance;
    		$id = $maintenance->id;
    	}
    	$data['maintenance_mode'] = $main_mode;
    	$data['id'] = $id;
        return view('maintenance', $data);
    }

    public function PostMaintenance(Request $request){
    	$validatedData = $request->validate([
            'maintenance_mode' => 'required',
        ]);
        if($request->get('id')){
        	DB::table('setting')->where("id", $request->get('id'))->update(["maintenance" => $request->get('maintenance_mode')]);
        }else{
        	DB::table('setting')->insert(["maintenance" => $request->get('maintenance_mode')]);
        }		
		$message = "Disable";
		if($request->get('maintenance_mode') == 1){
			$message = "Enable";
		}
        return redirect()->back()->with("success","Maintenance Mode successfully ".$message);

    }

    public function PostLoadingIndicator(Request $request){
        DB::table('setting')->where("id", 2)->update(["loading_indicator" => $request->get('loading_indicator')]);
    }

    public function PostDefaultTimeSetting(Request $request){
        $validatedData = $request->validate([
            'id' => 'required',
            'defaultTime' => 'required',
        ]);        
        if($request->get('id')){
            DB::table('setting')->where("id", $request->get('id'))->update(["defaulttime" => $request->get('defaultTime')]);
        }
        $response['error'] = false;
        $response['msg'] = "Successfully update default time!!";
        return response()->json($response);
    }
}
