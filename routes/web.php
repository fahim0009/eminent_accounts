<?php
  
use Illuminate\Support\Facades\Route;
  
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Agent\ClientController;
  
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

// cache clear
Route::get('/clear', function() {
    Auth::logout();
    session()->flush();
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return "Cleared!";
 });
//  cache clear
  
// Route::get('/', function () {
//     return view('welcome');
// });
  
Auth::routes();
Route::get('/', [FrontendController::class, 'index'])->name('homepage');
Route::get('/home', [HomeController::class, 'index'])->name('homepage');
  
/*------------------------------------------
--------------------------------------------
All Normal Users Routes List
--------------------------------------------
--------------------------------------------*/
Route::group(['prefix' =>'user/', 'middleware' => ['auth', 'is_user']], function(){
  
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});
  

/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::group(['prefix' =>'manager/', 'middleware' => ['auth', 'is_manager']], function(){
  
    Route::get('/dashboard', [HomeController::class, 'managerHome'])->name('manager.dashboard');


    // client
    Route::get('/client', [ClientController::class, 'index'])->name('manager.client');
    Route::get('/processing-clients', [ClientController::class, 'processing'])->name('manager.processingclient');
    Route::get('/decline-clients', [ClientController::class, 'decline'])->name('manager.declineclient');
    Route::get('/completed-clients', [ClientController::class, 'completed'])->name('manager.completedclient');
});
 