<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::any('/', function(){return redirect('/dashboard');});

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/changePassword','ChangeCurrentPasswordController@showChangePasswordForm')->name('changePassword');
Route::post('/changePassword','ChangeCurrentPasswordController@changePassword')->name('changePassword');

Route::get('/changeEmail','ChangeCurrentEmailController@showChangeEmailForm')->name('changeEmail');
Route::post('/changeEmail','ChangeCurrentEmailController@changeEmail')->name('changeEmail');

//Route::get('/create','WinnumbersController@create')->name('create');
//Route::post('/allowCreateVideo','WinnumbersController@allowCreateVideo');
Route::post('/store', 'WinnumbersController@store');
Route::post('/add', 'WinnumbersController@add');
Route::post('/delete', 'WinnumbersController@delete');

Route::match(['get', 'post'], '/dashboard', 'WinnumbersController@index')->name('dashboard');
Route::match(['get', 'post'], '/settings', 'WinnumbersController@settings');
Route::match(['get', 'post'], '/createdate', 'WinnumbersController@createdate');
Route::get('/fillCalendar', 'WinnumbersController@fillCal');

Route::post('/createdatecheck', 'WinnumbersController@createdatecheck');
Route::post('/adddate', 'WinnumbersController@adddate');

Route::match(['get', 'post'], '/api_setting', 'WinnumbersController@api_setting');
Route::post('/api_getdata', 'WinnumbersController@api_getdata');
Route::post('/api_update', 'WinnumbersController@api_update');
Route::post('/api_delete', 'WinnumbersController@api_delete');
Route::post('/api_create', 'WinnumbersController@api_create');

Route::post('/postRequest', 'WinnumbersController@fetch_data');
Route::post('/createNewNumbers', 'WinnumbersController@createNewNumbers');


Route::post('/deleteNumbers', 'WinnumbersController@deleteNumbers');
Route::post('/updateNumbers', 'WinnumbersController@updateNumbers');
Route::post('/selectMaxData', 'WinnumbersController@selectMaxData');

Route::get('/maintenance','MaintenanceController@showMaintenanceForm');
Route::post('/maintenance','MaintenanceController@PostMaintenance');
Route::post('/loading_indicator','WinnumbersController@PostLoadingIndicator');
Route::post('/set-default-time','MaintenanceController@PostDefaultTimeSetting');

Route::get('/view_log', 'WinnumbersController@viewLog');

Route::get('/changeTimezone/{tz}',function($tz){
  $newTimezone = str_replace("_", "/", $tz);
  $envOriginal = '';
  $result = '';

  $file = fopen(base_path('.env'),"r");

  while(! feof($file)){
    $envOriginal.= fgets($file). "\n";
  }

  fclose($file);


  foreach(preg_split("/((\r?\n)|(\r\n?))/", $envOriginal) as $line) {
    if(strlen($line) == 0) {
      $result .= 'newline';
    } else if(substr($line, 0, 13) == 'APP_TIMEZONE=') {
        $result .= 'APP_TIMEZONE='.$newTimezone."\n";
    } else if(strlen($line) > 0) {
        $result .= $line."\n";
    }
  }


  $result = str_replace("newlinenewlinenewline", "\n", $result);
  $result = str_replace("newline", "", $result);

  file_put_contents(base_path('.env'), $result);

  $exitCode = Artisan::call('config:cache');
  $exitCode = Artisan::call('config:clear');
  return Redirect::back();

});


/*
Route::get('/delete-allWinnumbers', function() {
  $exitCode = DB::table('winnumbers')->truncate();
  return '<h1>Table cleared</h1>';
});

Route::get('/clear-migrations', function () {
  return Artisan::call('migrate:reset', ["--force"=> true ]);
});

Route::get('/run-migrations', function () {
  return Artisan::call('migrate', ["--force"=> true ]);
});

//Clear Cache facade value:
Route::get('/clear-cache', function() {
  $exitCode = Artisan::call('cache:clear');
  return '<h1>Cache facade value cleared</h1>';
});*/

//Reoptimized class loader:
Route::get('/optimize', function() {
  $exitCode = Artisan::call('optimize');
  return '<h1>Reoptimized class loader</h1>';
});


//Route cache:
Route::get('/route-cache', function() {
  $exitCode = Artisan::call('route:cache');
  return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/route-clear', function() {
  $exitCode = Artisan::call('route:clear');
  return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function() {
  $exitCode = Artisan::call('view:clear');
  return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/config-cache', function() {
  $exitCode = Artisan::call('route:clear');
  $exitCode = Artisan::call('cache:clear');
  $exitCode = Artisan::call('config:cache');
  $exitCode = Artisan::call('view:cache');
  $exitCode = Artisan::call('config:cache');
  return '<h1>Clear Config cleared</h1>';
});
/*
//Clear Config cache:
Route::get('/cache-clear', function() {
  $exitCode = Artisan::call('cache:clear');
  return '<h1>Clear Config cleared</h1>';
});

*/

//Auth::routes();
