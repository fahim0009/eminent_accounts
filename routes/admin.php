<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\ContactMailController; 
use App\Http\Controllers\Admin\GalleryController; 
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\WorkController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Agent\AgentController;
use App\Http\Controllers\User\UserController;



/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::group(['prefix' =>'admin/', 'middleware' => ['auth', 'is_admin']], function(){
  
    Route::get('/dashboard', [HomeController::class, 'adminHome'])->name('admin.dashboard');
    //profile
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::put('profile/{id}', [AdminController::class, 'adminProfileUpdate']);
    Route::post('changepassword', [AdminController::class, 'changeAdminPassword']);
    Route::put('image/{id}', [AdminController::class, 'adminImageUpload']);
    //profile end
    //admin registration
    Route::get('register','App\Http\Controllers\Admin\AdminController@adminindex')->name('admin.registration');
    Route::post('register','App\Http\Controllers\Admin\AdminController@adminstore');
    Route::get('register/{id}/edit','App\Http\Controllers\Admin\AdminController@adminedit');
    Route::put('register/{id}','App\Http\Controllers\Admin\AdminController@adminupdate');
    Route::get('register/{id}', 'App\Http\Controllers\Admin\AdminController@admindestroy');
    //admin registration end
    //agent registration
    Route::get('agent-register','App\Http\Controllers\Admin\AdminController@agentindex');
    Route::post('agent-register','App\Http\Controllers\Admin\AdminController@agentstore');
    Route::get('agent-register/{id}/edit','App\Http\Controllers\Admin\AdminController@agentedit');
    Route::put('agent-register/{id}','App\Http\Controllers\Admin\AdminController@agentupdate');
    Route::get('agent-register/{id}', 'App\Http\Controllers\Admin\AdminController@agentdestroy');
    // certificate update
    // Route::post('image-upload', 'App\Http\Controllers\Admin\AdminController@agentCertificateUpdate')->name('image.upload.post');
    //agent registration end
    //user registration
    Route::get('user-register','App\Http\Controllers\Admin\AdminController@userindex')->name('alluser');;
    Route::post('user-register','App\Http\Controllers\Admin\AdminController@userstore');
    Route::get('user-register/{id}/edit','App\Http\Controllers\Admin\AdminController@useredit');
    Route::put('user-register/{id}','App\Http\Controllers\Admin\AdminController@userupdate');
    Route::get('user-register/{id}', 'App\Http\Controllers\Admin\AdminController@userdestroy');
    //user registration end
    //code master 
    Route::resource('softcode','App\Http\Controllers\Admin\SoftcodeController');
    Route::resource('master','App\Http\Controllers\Admin\MasterController');
    //code master end
    //company details
    Route::resource('company-detail','App\Http\Controllers\Admin\CompanyDetailController');
    //company details end
    //slider 
    Route::resource('sliders','App\Http\Controllers\Admin\SliderController');
    Route::get('activeslider','App\Http\Controllers\Admin\SliderController@activeslider');
    //slider end
    Route::resource('seo-settings','App\Http\Controllers\Admin\SeoSettingController');


    Route::resource('role','App\Http\Controllers\RoleController');
    Route::post('roleupdate','App\Http\Controllers\RoleController@roleUpdate');
    Route::resource('staff','App\Http\Controllers\StaffController');


    //accounts
    // Route::get('accounts', [AccountController::class, 'store']);
    Route::post('account', [AccountController::class, 'store']);
    Route::get('account/{id}/edit', [AccountController::class, 'edit']);
    Route::post('account-update', [AccountController::class, 'update']);
    //accounts end


    
    // service Category 
    Route::get('/service-category', [ServiceController::class, 'category'])->name('admin.service_category');
    Route::post('/service-category', [ServiceController::class, 'categorystore']);
    Route::get('/service-category/{id}/edit', [ServiceController::class, 'categoryedit']);
    Route::put('/service-category/{id}', [ServiceController::class, 'categoryupdate']);
    Route::get('/service-category/{id}', [ServiceController::class, 'categorydelete']);

    // service  
    Route::get('/service', [ServiceController::class, 'index'])->name('admin.service');
    Route::post('/service', [ServiceController::class, 'store']);
    Route::get('/service/{id}/edit', [ServiceController::class, 'edit']);
    Route::put('/service/{id}', [ServiceController::class, 'update']);
    Route::get('/service/{id}', [ServiceController::class, 'delete']);

    
    // news Category 
    Route::get('/news-category', [NewsController::class, 'category'])->name('admin.news_category');
    Route::post('/news-category', [NewsController::class, 'categorystore']);
    Route::get('/news-category/{id}/edit', [NewsController::class, 'categoryedit']);
    Route::put('/news-category/{id}', [NewsController::class, 'categoryupdate']);
    Route::get('/news-category/{id}', [NewsController::class, 'categorydelete']);

    // news 
    Route::get('/news', [NewsController::class, 'index'])->name('admin.news');
    Route::post('/news', [NewsController::class, 'store']);
    Route::get('/news/{id}/edit', [NewsController::class, 'edit']);
    Route::put('/news/{id}', [NewsController::class, 'update']);
    Route::get('/news/{id}', [NewsController::class, 'delete']);

    // blog Category 
    Route::get('/blog-category', [BlogController::class, 'category'])->name('admin.blog_category');
    Route::post('/blog-category', [BlogController::class, 'categorystore']);
    Route::get('/blog-category/{id}/edit', [BlogController::class, 'categoryedit']);
    Route::put('/blog-category/{id}', [BlogController::class, 'categoryupdate']);
    Route::get('/blog-category/{id}', [BlogController::class, 'categorydelete']);

    // blog  
    Route::get('/blog', [BlogController::class, 'index'])->name('admin.blog');
    Route::post('/blog', [BlogController::class, 'store']);
    Route::get('/blog/{id}/edit', [BlogController::class, 'edit']);
    Route::put('/blog/{id}', [BlogController::class, 'update']);
    Route::get('/blog/{id}', [BlogController::class, 'delete']);
    

    // gallery Category 
    Route::get('/gallery-category', [GalleryController::class, 'category'])->name('admin.gallery_category');
    Route::post('/gallery-category', [GalleryController::class, 'categorystore']);
    Route::get('/gallery-category/{id}/edit', [GalleryController::class, 'categoryedit']);
    Route::put('/gallery-category/{id}', [GalleryController::class, 'categoryupdate']);
    Route::get('/gallery-category/{id}', [GalleryController::class, 'categorydelete']);

    Route::get('/gallery', [GalleryController::class, 'index'])->name('admin.gallery');
    Route::post('/gallery', [GalleryController::class, 'store']);
    Route::get('/gallery/{id}/edit', [GalleryController::class, 'edit']);
    Route::put('/gallery/{id}', [GalleryController::class, 'update']);
    Route::get('/gallery/{id}', [GalleryController::class, 'delete']);

    // photo
    Route::get('/photo', [ImageController::class, 'index'])->name('admin.photo');
    Route::post('/photo', [ImageController::class, 'store']);
    Route::get('/photo/{id}/edit', [ImageController::class, 'edit']);
    Route::put('/photo/{id}', [ImageController::class, 'update']);
    Route::get('/photo/{id}', [ImageController::class, 'delete']);

    // work
    Route::get('/work', [WorkController::class, 'index'])->name('admin.work');
    Route::post('/work', [WorkController::class, 'store']);
    Route::get('/work/{id}/edit', [WorkController::class, 'edit']);
    Route::put('/work/{id}', [WorkController::class, 'update']);
    Route::get('/work/{id}', [WorkController::class, 'delete']);


    // job Category 
    Route::get('/job-category', [JobController::class, 'category'])->name('admin.job_category');
    Route::post('/job-category', [JobController::class, 'categorystore']);
    Route::get('/job-category/{id}/edit', [JobController::class, 'categoryedit']);
    Route::put('/job-category/{id}', [JobController::class, 'categoryupdate']);
    Route::get('/job-category/{id}', [JobController::class, 'categorydelete']);

    // job  
    Route::get('/job', [JobController::class, 'index'])->name('admin.job');
    Route::post('/job', [JobController::class, 'store']);
    Route::get('/job/{id}/edit', [JobController::class, 'edit']);
    Route::put('/job/{id}', [JobController::class, 'update']);
    Route::get('/job/{id}', [JobController::class, 'delete']);


    
    // agent request  
    Route::get('/agent-request', [JobController::class, 'getAgentRequest'])->name('admin.agentrequest');
    
    Route::get('/show-images/{id}', [ImageController::class, 'showImage'])->name('showimg');

    // contact mail 
    Route::get('/contact-mail', [ContactMailController::class, 'index'])->name('admin.contact-mail');
    Route::get('/contact-mail/{id}/edit', [ContactMailController::class, 'edit']);
    Route::put('/contact-mail/{id}', [ContactMailController::class, 'update'])->name('admin.contact.update');
});
//admin part end