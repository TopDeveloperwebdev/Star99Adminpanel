<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Session;

class FillModel extends Model
{
    public function fillCal() {

      $check = DB::table('winnumbers')->count();
      echo $check;

      if($check == 0){
    

        $result = '';
        // Start date
        $dateTest = date('Y-m-d', strtotime('-1095 days'));
        // End date
        $end_date = date('Y-m-d', strtotime('-730 days'));
        while ($dateTest <= $end_date) {
          for($count = 1; $count < 24; $count++){

            $result .= "(".$count.",'".str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT)."','".date('Y-m-d', strtotime($dateTest))."','".date('20:00:00')."','".date('Y-m-d H:i:s', strtotime($dateTest))."','".date('Y-m-d H:i:s', strtotime($dateTest))."'), ";
          }
          $dateTest = date ("Y-m-d", strtotime("+1 day", strtotime($dateTest)));
        }
        $result = substr($result, 0, -2);

        DB::statement("INSERT INTO `winnumbers`(`ranking`, `number`, `date`, `time`, `created_at`, `updated_at`) VALUES".$result);


        $result2 = '';
        // Start date
        $dateTest = date('Y-m-d', strtotime('-729 days'));
        // End date
        $end_date = date('Y-m-d', strtotime('-365 days'));
        while ($dateTest <= $end_date) {
          for($count = 1; $count < 24; $count++){

            $result2 .= "(".$count.",'".str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT)."','".date('Y-m-d', strtotime($dateTest))."','".date('20:00:00')."','".date('Y-m-d H:i:s', strtotime($dateTest))."','".date('Y-m-d H:i:s', strtotime($dateTest))."'), ";
          }
          $dateTest = date ("Y-m-d", strtotime("+1 day", strtotime($dateTest)));
        }
        $result2 = substr($result2, 0, -2);

        DB::statement("INSERT INTO `winnumbers`(`ranking`, `number`, `date`, `time`, `created_at`, `updated_at`) VALUES".$result2);

        $result3 = '';
        // Start date
        $dateTest = date('Y-m-d', strtotime('-364 days'));
        // End date
        $end_date = date('Y-m-d');
        while ($dateTest <= $end_date) {
          for($count = 1; $count < 24; $count++){

            $result3 .= "(".$count.",'".str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT)."','".date('Y-m-d', strtotime($dateTest))."','".date('20:00:00')."','".date('Y-m-d H:i:s', strtotime($dateTest))."','".date('Y-m-d H:i:s', strtotime($dateTest))."'), ";
          }
          $dateTest = date ("Y-m-d", strtotime("+1 day", strtotime($dateTest)));
        }
        $result3 = substr($result3, 0, -2);

        DB::statement("INSERT INTO `winnumbers`(`ranking`, `number`, `date`, `time`, `created_at`, `updated_at`) VALUES".$result3);
      
        Session::flash('message', "Calendar is filled for past 3 years!");
      } else {
        Session::flash('message-error', "Calendar is already created and filled!");
      }
     
  }
}
