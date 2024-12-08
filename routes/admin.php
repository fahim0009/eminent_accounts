<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ChartOfAccountController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\LoanController;
use App\Http\Controllers\Admin\AgentController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\BusinessPartnerController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\KafelaClientController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Admin\OkalaController;


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

    Route::get('/new-admin', [AdminController::class, 'getAdmin'])->name('alladmin');
    Route::post('/new-admin', [AdminController::class, 'adminStore']);
    Route::get('/new-admin/{id}/edit', [AdminController::class, 'adminEdit']);
    Route::post('/new-admin-update', [AdminController::class, 'adminUpdate']);
    Route::get('/new-admin/{id}', [AdminController::class, 'adminDelete']);
    Route::post('/users/{id}/status', [AdminController::class, 'updateStatus'])->name('updateStatus');
    
    Route::get('/agent', [AgentController::class, 'index'])->name('admin.agent');
    Route::get('/agent-client/{id}', [AgentController::class, 'getClient'])->name('admin.agentClient');
    Route::get('/agent-tran/{id}', [AgentController::class, 'getTran'])->name('admin.agentTran');
    Route::post('/agent', [AgentController::class, 'store']);
    Route::get('/agent/{id}/edit', [AgentController::class, 'edit']);
    Route::post('/agent-update', [AgentController::class, 'update']);
    Route::get('/agent/{id}', [AgentController::class, 'delete']);
    
    Route::get('/account', [AccountController::class, 'index'])->name('admin.account');
    Route::post('/account', [AccountController::class, 'store']);
    Route::get('/account/{id}/edit', [AccountController::class, 'edit']);
    Route::post('/account-update', [AccountController::class, 'update']);
    Route::get('/account/{id}', [AccountController::class, 'delete']);

    //ksa with job
    Route::get('/client', [ClientController::class, 'index'])->name('admin.client');
    Route::get('/processing-clients', [ClientController::class, 'processing'])->name('admin.processingclient');
    Route::get('/decline-clients', [ClientController::class, 'decline'])->name('admin.declineclient');
    Route::get('/completed-clients', [ClientController::class, 'completed'])->name('admin.completedclient');

    //ksa without job
    Route::get('/ksa-without-job-client', [ClientController::class, 'withoutjobindex'])->name('withoutjob.client');
    Route::get('/ksa-without-job-processing-clients', [ClientController::class, 'withoutjobprocessing'])->name('withoutjob.processingclient');
    Route::get('/ksa-without-job-decline-clients', [ClientController::class, 'withoutjobdecline'])->name('withoutjob.declineclient');
    Route::get('/ksa-without-job-completed-clients', [ClientController::class, 'withoutjobcompleted'])->name('withoutjob.completedclient');


    Route::post('/client', [ClientController::class, 'store']);
    Route::get('/client/{id}/edit', [ClientController::class, 'edit']);
    Route::post('/client-update', [ClientController::class, 'update']);
    Route::get('/client/{id}', [ClientController::class, 'delete']);
    Route::get('/client-details/{id}', [ClientController::class, 'getClientInfo'])->name('admin.clientDetails');
    Route::post('/client-partner-update', [ClientController::class, 'partnerUpdate']);
    Route::get('/change-client-status', [ClientController::class, 'changeClientStatus']);

    // download
    Route::get('/client-image-download/{id}', [ClientController::class, 'client_image_download'])->name('client_image.download');
    Route::get('/visa-image-download/{id}', [ClientController::class, 'visa_image_download'])->name('visa_image.download');
    Route::get('/manpower-image-download/{id}', [ClientController::class, 'manpower_image_download'])->name('manpower_image.download');
    Route::get('/passport-image-download/{id}', [ClientController::class, 'passport_image_download'])->name('passport_image.download');

    
    Route::post('getchartofaccount', [ChartOfAccountController::class, 'getaccounthead']);
    Route::get('/chart-of-account', [ChartOfAccountController::class, 'index'])->name('admin.coa');
    Route::post('/chart-of-account', [ChartOfAccountController::class, 'store']);
    Route::get('/chart-of-account/{id}/edit', [ChartOfAccountController::class, 'edit']);
    Route::post('/chart-of-account-update', [ChartOfAccountController::class, 'update']);
    Route::get('/chart-of-account/{id}', [ChartOfAccountController::class, 'delete']);

    
    Route::get('/loan', [LoanController::class, 'index'])->name('admin.loan');
    Route::post('/loan', [LoanController::class, 'store']);
    Route::get('/loan/{id}/edit', [LoanController::class, 'edit']);
    Route::post('/loan-update', [LoanController::class, 'update']);
    Route::get('/loan/{id}', [LoanController::class, 'delete']);

    Route::get('/loan-return-history/{id}', [LoanController::class, 'loanReturnHistory'])->name('admin.loanReturnHistory');
    Route::post('/loan-return', [LoanController::class, 'loanReturnStore']);
    Route::get('/loan-return/{id}/edit', [LoanController::class, 'loanReturnedit']);
    Route::post('/loan-return-update', [LoanController::class, 'loanReturnUpdate']);

    
    Route::get('/country', [CountryController::class, 'index'])->name('admin.country');
    Route::post('/country', [CountryController::class, 'store']);
    Route::get('/country/{id}/edit', [CountryController::class, 'edit']);
    Route::post('/country-update', [CountryController::class, 'update']);
    Route::get('/country/{id}', [CountryController::class, 'delete']);

    
    Route::get('/business-partner', [BusinessPartnerController::class, 'index'])->name('admin.businesspartner');
    Route::post('/business-partner', [BusinessPartnerController::class, 'store']);
    Route::get('/business-partner/{id}/edit', [BusinessPartnerController::class, 'edit']);
    Route::post('/business-partner-update', [BusinessPartnerController::class, 'update']);
    Route::get('/business-partner/{id}', [BusinessPartnerController::class, 'delete']);

    // transaction
    Route::post('/money-receipt', [TransactionController::class, 'moneyreceived']);
    Route::post('/money-receipt-update', [TransactionController::class, 'moneyReceivedUpdate']);
    Route::get('/money-receipt/{id}/edit', [TransactionController::class, 'moneyReceivedEdit']);

    // payment
    Route::post('/money-payment', [TransactionController::class, 'moneyPayment']);
    Route::post('/money-payment-update', [TransactionController::class, 'moneyPaymentUpdate']);
    Route::get('/money-payment/{id}/edit', [TransactionController::class, 'moneyPaymentEdit']);

    // kafela client
    Route::get('/kafela-client', [KafelaClientController::class, 'index'])->name('admin.kafelaclient');
    Route::get('/kafela-decline-clients', [KafelaClientController::class, 'decline'])->name('admin.kafeladeclineclient');
    Route::get('/kafela-completed-clients', [KafelaClientController::class, 'completed'])->name('admin.kafelacompletedclient');
    Route::post('/kafela-client', [KafelaClientController::class, 'store']);
    Route::get('/kafela-client/{id}/edit', [KafelaClientController::class, 'edit']);
    Route::post('/kafela-client-update', [KafelaClientController::class, 'update']);
    Route::get('/kafela-client/{id}', [KafelaClientController::class, 'delete']);
    Route::get('/change-kafela-client-status', [KafelaClientController::class, 'changeClientStatus']);

    //vendor
    Route::get('/vendor', [VendorController::class, 'index'])->name('admin.vendor');
    Route::post('/vendor', [VendorController::class, 'store']);
    Route::get('/vendor/{id}/edit', [VendorController::class, 'edit']);
    Route::post('/vendor-update', [VendorController::class, 'update']);
    Route::get('/vendor/{id}', [VendorController::class, 'delete']);
    Route::post('/vendor/{id}/status', [VendorController::class, 'updateStatus']);

    
    //okala
    Route::get('/okala', [OkalaController::class, 'index'])->name('admin.okala');
    Route::get('/okala-purchase', [OkalaController::class, 'okalaPurchase'])->name('admin.okalapurchase');
    Route::get('/okala-purchase/{id}', [OkalaController::class, 'okalapurchaseDetails'])->name('admin.okalapurchaseDetails');
    Route::get('/okala-assigned', [OkalaController::class, 'assignedOkala'])->name('admin.assignokala');
    Route::post('/okala', [OkalaController::class, 'store']);
    Route::get('/okala/{id}/edit', [OkalaController::class, 'edit']);
    Route::post('/okala-update', [OkalaController::class, 'update']);
    Route::get('/okala/{id}', [OkalaController::class, 'delete']);

    Route::post('/client-add-okala', [OkalaController::class, 'addClientToOkala']);

    // okala sales
    Route::get('/okala-sales', [OkalaController::class, 'salesindex'])->name('admin.okalasales');
    Route::post('/okala-sales', [OkalaController::class, 'salesstore']);
    Route::get('/okala-sales/{id}/edit', [OkalaController::class, 'salesedit']);
    Route::post('/okala-sales-update', [OkalaController::class, 'salesupdate']);
    Route::get('/okala-sales/{id}', [OkalaController::class, 'salesdelete']);


});
  