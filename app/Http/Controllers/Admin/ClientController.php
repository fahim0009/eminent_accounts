<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\BusinessPartner;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Client;
use App\Models\CodeMaster;
use App\Models\Country;
use App\Models\Transaction;
// use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index()
    {
        $data = Client::where('is_job','1')->orderby('id','ASC')->get();
        $count = $data->count();
        $agents = User::where('is_type','2')->where('status', 1)->get();
        $countries = CodeMaster::where('type','COUNTRY')->orderby('id','DESC')->get();
        $accounts = Account::orderby('id','DESC')->get();
        // $bpartners = BusinessPartner::orderby('id','DESC')->get();
        return view('admin.client.index', compact('data','agents','countries','accounts','count'));
    }

    public function newClient()
    {
        $data = Client::where('is_job','1')->where('status','0')->orderby('id','ASC')->get();
        $count = $data->count();
        $agents = User::where('is_type','2')->where('status', 1)->get();
        $countries = CodeMaster::where('type','COUNTRY')->orderby('id','DESC')->get();
        $accounts = Account::orderby('id','DESC')->get();
        return view('admin.client.new', compact('data','agents','countries','accounts','count'));
    }


    public function processing()
    {
        $data = Client::where('is_job','1')->where('status','1')->orderby('id','ASC')->get();
        $count = $data->count();
        $agents = User::where('is_type','2')->where('status', 1)->get();
        $countries = CodeMaster::where('type','COUNTRY')->orderby('id','DESC')->get();
        $accounts = Account::orderby('id','DESC')->get();
        // $bpartners = BusinessPartner::orderby('id','DESC')->get();
        return view('admin.client.processing', compact('data','agents','countries','accounts','count'));
    }

    public function decline()
    {
        $data = Client::where('is_job','1')->where('status','3')->orderby('id','ASC')->get();
        $agents = User::where('is_type','2')->where('status', 1)->get();
        $countries = CodeMaster::where('type','COUNTRY')->orderby('id','DESC')->get();
        $accounts = Account::orderby('id','DESC')->get();
        // $bpartners = BusinessPartner::orderby('id','DESC')->get();
        return view('admin.client.decline', compact('data','agents','countries','accounts'));
    }

    public function completed()
    {
        $data = Client::where('is_job','1')->where('status','2')->orderby('id','ASC')->get();
        $agents = User::where('is_type','2')->where('status', 1)->get();
        $countries = CodeMaster::where('type','COUNTRY')->orderby('id','DESC')->get();
        $accounts = Account::orderby('id','DESC')->get();
        // $bpartners = BusinessPartner::orderby('id','DESC')->get();
        return view('admin.client.completed', compact('data','agents','countries','accounts'));
    }

    // ksa new client
    public function ksaNewClient()
    {
        $clients = DB::table('clients')
        ->leftJoin('code_masters as mofa_code_masters', 'clients.mofa_trade', '=', 'mofa_code_masters.id') // First join
        ->leftJoin('code_masters as rlid_code_masters', 'clients.rlid', '=', 'rlid_code_masters.id') // Second join
        ->leftJoin('users', 'clients.user_id', '=', 'users.id') // Join users table
        ->select(
            'clients.*', 
            'mofa_code_masters.type_name as mofa_trade', // Type name for mofa_trade
            'rlid_code_masters.type_name as rlname', // Type name for rlid
            'users.id as user_id', 
            'users.name as user_name', 
            'users.surname as user_surname'
        )
        ->where('clients.status', '0')
        ->orderBy('clients.id', 'ASC')
        ->get();

        $count = $clients->count();
        return view('admin.client.ksanew', compact('clients','count'));
    }

    // ksa processing client
    public function ksaProcessingClient()
    {
        $data = Client::where('status','1')->orderby('id','ASC')->get();
        $count = $data->count();
        return view('admin.client.ksaprocessing', compact('data','count'));
    }

    public function ksaMedicalExpireDate(Request $request)
    {
        $data = Client::find($request->id);
        $data->medical_exp_date = $request->medical_exp_date;
        $data->updated_by = Auth::user()->id;
        if ($data->save()) {
            $message ="Medical Expire Date Updated Successfully.";
            return response()->json(['status'=> 300,'message'=>$message]);
        }
        else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }

    public function ksaMofaTrade(Request $request)
    {
        $data = Client::find($request->id);
        $data->mofa_trade = $request->mofa_trade;
        $data->updated_by = Auth::user()->id;
        if ($data->save()) {
            $message ="MOFA Trade Updated Successfully.";
            return response()->json(['status'=> 300,'message'=>$message]);
        }
        else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }

    public function ksaRL(Request $request)
    {
        $data = Client::find($request->id);
        $data->rlid = $request->rldetail;
        $data->updated_by = Auth::user()->id;
        if ($data->save()) {
            $message ="RL Updated Successfully.";
            return response()->json(['status'=> 300,'message'=>$message]);
        }
        else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }

    // visaUpdate

    public function visaUpdate(Request $request)
    {


        if(empty($request->visa_date) || empty($request->visa_image)){
            $message ="VISA Date & VISA PDF both are required.";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        $data = Client::find($request->id);
        $data->visa_exp_date = $request->visa_date;
        // visa_image
        if ($request->visa_image) {
            if ($data->visa) {
                $oldVisaPath = public_path('images/client/visa/') . $data->visa;
                if (file_exists($oldVisaPath)) {
                    unlink($oldVisaPath);
                }
            }
            $request->validate([
                'visa_image' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',
            ]);
            $rand = mt_rand(100000, 999999);
            $visa_imageName = time(). $rand .'.'.$request->visa_image->extension();
            $request->visa_image->move(public_path('images/client/visa'), $visa_imageName);
            $data->visa = $visa_imageName;
        }
        $data->updated_by = Auth::user()->id;
        if ($data->save()) {
            $message ="Visa Updated Successfully.";
            return response()->json(['status'=> 300,'message'=>$message]);
        }
        else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }

    // medicalUpdate
    public function manpowerUpdate(Request $request)
    {
   
        $data = Client::find($request->id);

        if ($request->manpower_image) {
            if ($data->manpower_image) {
                $oldmanpowerPath = public_path('images/client/manpower/') . $data->manpower_image;
                if (file_exists($oldmanpowerPath)) {
                    unlink($oldmanpowerPath);
                }
            }
            $request->validate([
                'manpower_image' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',
            ]);
            $rand = mt_rand(100000, 999999);
            $manpower_imageName = time() . $rand . '.' . $request->manpower_image->extension();
            $request->manpower_image->move(public_path('images/client/manpower'), $manpower_imageName);
            $data->manpower_image = $manpower_imageName;
        }

        $data->updated_by = Auth::user()->id;
        if ($data->save()) {
            $message = "Manpower file uploaded Successfully.";
            return response()->json(['status' => 300, 'message' => $message]);
        } else {
            return response()->json(['status' => 303, 'message' => 'Server Error!!']);
        }
    }
 

    // fly date update
    public function flyDateUpdate(Request $request)
    {
        $request->validate([
            'flight_date' => 'required',
        ]);

        $data = Client::find($request->id);
        $data->flight_date = $request->flight_date;


        $data->status = 2;
        $data->updated_by = Auth::user()->id;
        if ($data->save()) {
            $message = "Fligit or Delivery Date Successfully.";
            return response()->json(['status' => 300, 'message' => $message]);
        } else {
            return response()->json(['status' => 303, 'message' => 'Server Error!!']);
        }
    }

    //trainingfingerUpdate
    public function trainingfingerUpdate(Request $request)
    {
        $request->validate([
            'training' => 'required',
            'finger' => 'required',
        ]);

        $data = Client::find($request->id);
        $data->finger = $request->finger;
        $data->training = $request->training;
        $data->updated_by = Auth::user()->id;
        if ($data->save()) {
            $message = "Training Finger Updated Successfully.";
            return response()->json(['status' => 300, 'message' => $message]);
        } else {
            return response()->json(['status' => 303, 'message' => 'Server Error!!']);
        }
    }



    // ksa without job start
    public function withoutjobindex()
    {
        $data = Client::where('is_job','0')->orderby('id','ASC')->get();
        $count = $data->count();
        $agents = User::where('is_type','2')->where('status', 1)->get();
        $countries = CodeMaster::where('type','COUNTRY')->orderby('id','DESC')->get();
        $accounts = Account::orderby('id','DESC')->get();
        return view('admin.withoutjobclient.index', compact('data','agents','countries','accounts','count'));
    }

    public function withoutjobnew()
    {
        $data = Client::where('is_job','0')->where('status','0')->orderby('id','ASC')->get();
        $count = $data->count();
        $agents = User::where('is_type','2')->where('status', 1)->get();
        $countries = CodeMaster::where('type','COUNTRY')->orderby('id','DESC')->get();
        $accounts = Account::orderby('id','DESC')->get();
        return view('admin.withoutjobclient.new', compact('data','agents','countries','accounts','count'));
    }

    public function withoutjobprocessing()
    {
        $data = Client::where('is_job','0')->where('status','1')->orderby('id','ASC')->get();
        $count = $data->count();
        $agents = User::where('is_type','2')->where('status', 1)->get();
        $countries = CodeMaster::where('type','COUNTRY')->orderby('id','DESC')->get();
        $accounts = Account::orderby('id','DESC')->get();
        // $bpartners = BusinessPartner::orderby('id','DESC')->get();
        return view('admin.withoutjobclient.processing', compact('data','agents','countries','accounts','count'));
    }

    public function withoutjobdecline()
    {
        $data = Client::where('is_job','0')->where('status','3')->orderby('id','ASC')->get();
        $agents = User::where('is_type','2')->where('status', 1)->get();
        $countries = CodeMaster::where('type','COUNTRY')->orderby('id','DESC')->get();
        $accounts = Account::orderby('id','DESC')->get();
        // $bpartners = BusinessPartner::orderby('id','DESC')->get();
        return view('admin.withoutjobclient.decline', compact('data','agents','countries','accounts'));
    }

    public function withoutjobcompleted()
    {
        $data = Client::where('is_job','0')->where('status','2')->orderby('id','ASC')->get();
        $agents = User::where('is_type','2')->where('status', 1)->get();
        $countries = CodeMaster::where('type','COUNTRY')->orderby('id','DESC')->get();
        $accounts = Account::orderby('id','DESC')->get();
        // $bpartners = BusinessPartner::orderby('id','DESC')->get();
        return view('admin.withoutjobclient.completed', compact('data','agents','countries','accounts'));
    }
    // ksa without job end

    public function getClientInfo($id)
    {
        $data = Client::where('id',$id)->first();
        $trans = Transaction::where('client_id',$id)->orderby('id','DESC')->get();
        $agents = User::where('is_type','2')->get();
        $countries = CodeMaster::where('type','COUNTRY')->orderby('id','DESC')->get();
        $accounts = Account::orderby('id','DESC')->get();
        return view('admin.client.clientdetail', compact('data','agents','countries','accounts','trans'));
    }

    public function store(Request $request)
    {
        if(empty($request->user_id)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Agent \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->passport_number)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Passport Number \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->passport_name)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Passport Name \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->passport_rcv_date)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Passport Receive Date \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->package_cost)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Package Cost \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        
        $chkpNumber = Client::where('passport_number',$request->passport_number)->whereNotNull('passport_number')->first();

        if($chkpNumber){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>This Person $chkpNumber->passport_name  ($chkpNumber->passport_number) already added.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }


        $data = new Client;
        $data->user_id = $request->user_id;
        $data->clientid = $request->clientid;
        $data->passport_number = $request->passport_number;
        $data->passport_name = $request->passport_name;
        $data->passport_rcv_date = $request->passport_rcv_date;
        $data->country_id = $request->country;
        $data->package_cost = $request->package_cost;
        $data->description = $request->description;
        $data->is_job = $request->is_job;
        $data->status = 0;
        $data->is_ticket = $request->is_ticket;

        // image
        if ($request->passport_image != 'null') {
            $request->validate([
                'passport_image' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:8048',
            ]);
            $rand = mt_rand(100000, 999999);
            $passporImageName = time(). $rand .'.'.$request->passport_image->extension();
            $request->passport_image->move(public_path('images/client/passport'), $passporImageName);
            $data->passport_image = $passporImageName;
        }
        // end

        // image
        if ($request->client_image != 'null') {
            $request->validate([
                'client_image' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:8048',
            ]);
            $rand = mt_rand(100000, 999999);
            $client_imageName = time(). $rand .'.'.$request->client_image->extension();
            $request->client_image->move(public_path('images/client'), $client_imageName);
            $data->client_image = $client_imageName;
        }
        // end



        $data->created_by = Auth::user()->id;
        if ($data->save()) {
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Create Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }

    public function edit($id)
    {
        $where = [
            'id'=>$id
        ];
        $info = Client::where($where)->get()->first();
        return response()->json($info);
    }

    public function update(Request $request)
    {

        $alldata = $request->all();

        if(empty($request->user_id)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Agent \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }


        $chkemail = Client::where('clientid',$request->clientid)->where('id','!=', $request->codeid)->whereNotNull('clientid')->first();
        if($chkemail){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>This client ID already added.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        


        $data = Client::find($request->codeid);

        if ($data->status == 0) {
            $stsval = "New";
        }elseif($data->status == 1){
            $stsval = "Processing";
        }elseif($data->status == 2){
            $stsval = "Complete";
        }elseif($data->status == 3){
            $stsval = "Decline";
        }else{
            $stsval = "Something is wrong";
        }

        if (($data->status == 1 || $data->status == 2) && ($data->package_cost != $request->package_cost)) {
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Package cost edit is not possible because passenger already in ".$stsval.". It has a transaction data.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        $data->user_id = $request->user_id;
        $data->clientid = $request->clientid;
        $data->passport_number = $request->passport_number;
        $data->passport_name = $request->passport_name;
        $data->passport_rcv_date = $request->passport_rcv_date;
        $data->country_id = $request->country;
        $data->package_cost = $request->package_cost;
        $data->description = $request->description;
        $data->flight_date = $request->flight_date;
        $data->visa_exp_date = $request->visa_exp_date;
        
        if (($data->status == 1) && isset($request->flight_date)) {
            $data->status = 2;
        }

        // image
        if ($request->passport_image != 'null') {
            $request->validate([
                'passport_image' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',
            ]);
            $rand = mt_rand(100000, 999999);
            $passporImageName = time(). $rand .'.'.$request->passport_image->extension();
            $request->passport_image->move(public_path('images/client/passport'), $passporImageName);
            $data->passport_image = $passporImageName;
        }
        // end

        // image
        if ($request->client_image != 'null') {
            $request->validate([
                'client_image' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',
            ]);
            $rand = mt_rand(100000, 999999);
            $client_imageName = time(). $rand .'.'.$request->client_image->extension();
            $request->client_image->move(public_path('images/client'), $client_imageName);
            $data->client_image = $client_imageName;
        }
        // end

        // image
        if (isset($request->visa_image)) {
            $request->validate([
                'visa_image' => 'nullable|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',
            ]);
            $rand = mt_rand(100000, 999999);
            $visaImageName = time(). $rand .'.'.$request->visa_image->extension();
            $request->visa_image->move(public_path('images/client/visa'), $visaImageName);
            $data->visa = $visaImageName;
        }
        // end

        // image
        if (isset($request->manpower_image)) {
            $request->validate([
                'manpower_image' => 'nullable|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',
            ]);
            $rand = mt_rand(100000, 999999);
            $manpower_imageName = time(). $rand .'.'.$request->manpower_image->extension();
            $request->manpower_image->move(public_path('images/client/manpower'), $manpower_imageName);
            $data->manpower_image = $manpower_imageName;
        }
        // end

        $data->updated_by = Auth::user()->id;
        if ($data->save()) {
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Updated Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message,'alldata'=>$alldata]);
        }
        else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        } 
    }

    public function delete($id)
    {

        if(Client::destroy($id)){
            return response()->json(['success'=>true,'message'=>'Data has been deleted successfully']);
        }else{
            return response()->json(['success'=>false,'message'=>'Delete Failed']);
        }
    }


    public function partnerUpdate(Request $request)
    {

        
        if(empty($request->business_partner_id)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Business Partner \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(empty($request->b2b_contact)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Contact Amount \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        
        $data = Client::find($request->codeid);
        $data->business_partner_id = $request->business_partner_id;
        $data->b2b_contact = $request->b2b_contact;
        $data->updated_by = Auth::user()->id;
        if ($data->save()) {
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Business Partner Updated Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }
        else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        } 
    }

    public function changeClientStatus(Request $request)
    {
        $user = Client::find($request->id);

        if ($user->status == 0) {
            $stsval = "New";
        }elseif($user->status == 1){
            $stsval = "Processing";
        }elseif($user->status == 2){
            $stsval = "Complete";
        }elseif($user->status == 3){
            $stsval = "Decline";
        }else{
            $stsval = "Something is wrong";
        }

        if (($user->status == 1 || $user->status == 2) && ($request->status == 3)) {
            $message ="Decline is not possible because passenger already in ".$stsval.". It has a transaction data.";
            return response()->json(['status'=> 300,'message'=>$message,'stsval'=>$stsval,'id'=>$request->id]);
        }

        if ($user->status == $request->status) {
            $message ="Passenger already in ".$stsval." .";
            return response()->json(['status'=> 300,'message'=>$message,'stsval'=>$stsval,'id'=>$request->id]);
        }


        if ($user->status == $request->status) {

            $message ="Passenger already in ".$stsval." .";
            return response()->json(['status'=> 300,'message'=>$message,'stsval'=>$stsval,'id'=>$request->id]);
        }

        $user->status = $request->status;
        if($user->save()){

            if ($request->status == 1) {
                $tran = new Transaction();
                $tran->date = $user->passport_rcv_date;
                $tran->tran_type = "package_sales";
                $tran->payment_type = "Receivable";
                $tran->bdt_amount = $user->package_cost;
                $tran->user_id = $user->user_id;
                $tran->client_id = $user->id;
                $tran->ref = "Package ". $user->passport_name . " (".$user->passport_number.")";
                $tran->save();
                $tran->tran_id = 'VS' . date('ymd') . str_pad($tran->id, 4, '0', STR_PAD_LEFT);
                $tran->save();
            }

            if ($user->status == 0) {
                $stsval = "New";
            }elseif($user->status == 1){
                $stsval = "Processing";
            }elseif($user->status == 2){
                $stsval = "Complete";
            }elseif($user->status == 3){
                $stsval = "Decline";
            }else{
                $stsval = "Something is wrong";
            }
    
            
            $message ="Status Change Successfully.";
            return response()->json(['status'=> 300,'message'=>$message,'stsval'=>$stsval,'id'=>$request->id]);
        }else{
            $message ="There was an error to change status!!.";
            return response()->json(['status'=> 303,'message'=>$message]);
        }

    }

    public function client_image_download($id)
    {

        $client_image = Client::where('id', $id)->first()->client_image;

        $filepath = public_path('images/client/').$client_image;
        if (isset($filepath)) {
            return Response::download($filepath);
        }
        
    }

    public function passport_image_download($id)
    {

        $passport_image = Client::where('id', $id)->first()->passport_image;

        $filepath = public_path('images/client/passport/').$passport_image;
        if (isset($filepath)) {
            return Response::download($filepath);
        }
        
    }

    public function visa_image_download($id)
    {

        $visa = Client::where('id', $id)->first()->visa;

        $filepath = public_path('images/client/visa/').$visa;
        if (isset($filepath)) {
            return Response::download($filepath);
        }
        
    }

    public function manpower_image_download($id)
    {

        $manpower = Client::where('id', $id)->first()->manpower_image;

        $filepath = public_path('images/client/manpower/').$manpower;
        if (isset($filepath)) {
            return Response::download($filepath);
        }
        
    }



}
