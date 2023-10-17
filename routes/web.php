<?php

use Illuminate\Support\Facades\Route;
  
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FrontendController;

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

Route::get('/home-page', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', [FrontendController::class, 'index'])->name('homepage');
Route::get('/about', [FrontendController::class, 'about'])->name('frontend.about');
Route::get('/contact', [FrontendController::class, 'contact'])->name('frontend.contact');
Route::get('/job', [FrontendController::class, 'job'])->name('frontend.job');
Route::get('/job/{id}', [FrontendController::class, 'jobdtl'])->name('frontend.jobdtl');
Route::get('/country', [FrontendController::class, 'country'])->name('frontend.country');
Route::get('/blog', [FrontendController::class, 'blog'])->name('frontend.blog');
Route::get('/blog/{id}', [FrontendController::class, 'blogDetails'])->name('blogdtl');


Route::get('/become-an-agent', [FrontendController::class, 'becomeAnAgent'])->name('becomeanagent');
Route::post('/become-an-agent', [FrontendController::class, 'becomeAnAgentStore'])->name('becomeagent.store');


Route::get('/job-category', [FrontendController::class, 'jobCategory'])->name('frontend.jobcategory');
/*------------------------------------------
--------------------------------------------
All Normal Users Routes List
--------------------------------------------
--------------------------------------------*/
Route::group(['prefix' =>'user/', 'middleware' => ['auth', 'is_user']], function(){
  
    Route::get('user-dashboard', [HomeController::class, 'userHome'])->name('user.dashboard');
});
  
/*------------------------------------------
--------------------------------------------
All Agent Routes List
--------------------------------------------
--------------------------------------------*/
Route::group(['prefix' =>'agent/', 'middleware' => ['auth', 'is_agent']], function(){
  
    Route::get('agent-dashboard', [HomeController::class, 'agentHome'])->name('agent.dashboard');
});
  

