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
use App\Models\MofaHistory;
use App\Models\Transaction;

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
            $latestHistory = DB::table('mofa_histories as mh1')
            ->select('mh1.client_id', DB::raw('MAX(mh1.id) as latest_id'))
            ->groupBy('mh1.client_id');

        // Now join that subquery and resolve the foreign keys
        $clients = DB::table('clients')
            ->leftJoinSub($latestHistory, 'latest_mh', function ($join) {
                $join->on('clients.id', '=', 'latest_mh.client_id');
            })
            ->leftJoin('mofa_histories', 'mofa_histories.id', '=', 'latest_mh.latest_id')
            ->leftJoin('code_masters as mofa_code_masters', 'mofa_histories.mofa_trade', '=', 'mofa_code_masters.id')
            ->leftJoin('code_masters as rlid_code_masters', 'mofa_histories.rlid', '=', 'rlid_code_masters.id')
            ->leftJoin('users', 'clients.user_id', '=', 'users.id')
            ->select(
                'clients.*',
                'mofa_code_masters.type_name as mofa_trade',
                'rlid_code_masters.type_name as rlname',
                'users.id as agent_id',
                'users.name as agent_name',
                'users.surname as agent_surname'
            )
            ->where('clients.status', '0')
            ->orderBy('clients.id', 'ASC')
            ->get();

        $count = $clients->count();
        return view('admin.client.ksanew', compact('clients', 'count'));
    }

    // ksa processing client
    public function ksaProcessingClient($type = Null)
    {

        $latestHistory = DB::table('mofa_histories as mh1')
        ->select('mh1.client_id', DB::raw('MAX(mh1.id) as latest_id'))
        ->groupBy('mh1.client_id');

    // Now join that subquery and resolve the foreign keys
    $data = DB::table('clients')
        ->leftJoinSub($latestHistory, 'latest_mh', function ($join) {
            $join->on('clients.id', '=', 'latest_mh.client_id');
        })
        ->leftJoin('mofa_histories', 'mofa_histories.id', '=', 'latest_mh.latest_id')
        ->leftJoin('code_masters as mofa_code_masters', 'mofa_histories.mofa_trade', '=', 'mofa_code_masters.id')
        ->leftJoin('code_masters as rlid_code_masters', 'mofa_histories.rlid', '=', 'rlid_code_masters.id')
        ->leftJoin('users', 'clients.user_id', '=', 'users.id')
        ->select(
            'clients.*',
            'mofa_code_masters.type_name as mofa_trade',
            'rlid_code_masters.type_name as rlname',
            'users.id as agent_id',
            'users.name as agent_name',
            'users.surname as agent_surname'
        )
        ->where('clients.status', '1')
        ->orderBy('clients.id', 'ASC')
        ->get();

    $count = $data->count();
    return view('admin.client.ksaprocessing', compact('data', 'count'));
        
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

    public function ksaMofaRl(Request $request)
    {

        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'agent_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'mofa_trade' => 'required|exists:code_masters,id',
            'rlid' => 'required|exists:code_masters,id',
        ]);

    try {
        MofaHistory::create([
            'client_id'   => $request->client_id,
            'user_id'     => $request->agent_id,
            'date'        => $request->date,
            'mofa_trade'  => $request->mofa_trade,
            'rlid'        => $request->rlid,
            'status'      => 1, // default status if needed
            'created_by'  => auth()->user()->name ?? 'system',
            'updated_by'  => auth()->user()->name ?? 'system',
        ]);

        return response()->json(['status' => 300, 'message' => 'MOFA record saved successfully']);
    } catch (\Exception $e) {
        return response()->json(['status' => 303, 'message' => 'Error: ' . $e->getMessage()]);
    }

    }

    public function changeMofaRequestStatus(Request $request)
    {
        $client = Client::find($request->id);

        if (!$client) {
            return response()->json(['status' => 404, 'message' => 'Client not found.']);
        }

        // If status is 1, validate required fields
        if ($request->status == 1) {
            if (empty($client->rlid) || empty($client->mofa_trade)) {
                return response()->json([
                    'status' => 303,
                    'message' => 'RLID and MOFA Trade must be set before changing the status.'
                ]);
            }

            $client->mofa += 1;
        }

        $client->mofa_request = 0;
        $client->updated_by = Auth::id();

        if ($client->save()) {
            $this->updateMofaHistory($client, $request->status);

            return response()->json([
                'status' => 300,
                'message' => 'Status changed successfully.'
            ]);
        }

        return response()->json([
            'status' => 303,
            'message' => 'Server error!'
        ]);
    }


    private function updateMofaHistory(Client $client, int $status): void
    {
        $history = MofaHistory::where('client_id', $client->id)
            ->where('status', 0)
            ->latest()
            ->first();

        if ($history) {
            if ($status == 1) {
                $history->mofa_trade = $client->mofa_trade;
                $history->rlid = $client->rlid;
            }

            $history->status = $status;
            $history->save();
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
        $data = Client::with(['mofaHistories.mofaTrade', 'mofaHistories.rlidCode'])->find($id);
        $trans = Transaction::where('client_id',$id)->orderby('id','DESC')->get();
        $agents = User::where('is_type','2')->get();
        $countries = CodeMaster::where('type','COUNTRY')->orderby('id','DESC')->get();
        $accounts = Account::orderby('id','DESC')->get();

        $assign = DB::table('okala_purchase_details as opd')
            ->join('users as u', 'opd.user_id', '=', 'u.id')
            ->where('opd.assign_to', $id)
            ->select('opd.*', 'u.name as vendor_name', 'u.surname as vendor_surname') // adjust fields as needed
            ->get();
        //  dd($assign);   
        return view('admin.client.clientdetail', compact('data','agents','countries','accounts','trans','assign'));
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
        }elseif($data->status == 4){
            $stsval = "Visa Cancel";
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
    $client = Client::find($request->id);
    $oldStatus = $client->status; // capture old status

    // Determine old status label
    $stsval = match($oldStatus) {
        0 => "New",
        1 => "Processing",
        2 => "Complete",
        3 => "Decline",
        4 => "Visa Cancel",
        default => "Something is wrong"
    };

    // Prevent change if already complete or declined
    if ($oldStatus == 2 || $oldStatus == 3) {
        $message = "Status change is not possible because passenger already in $stsval.";
        return response()->json(['status' => 300, 'message' => $message, 'stsval' => $stsval, 'id' => $request->id]);
    }

    // Prevent setting the same status again
    if ($oldStatus == $request->status) {
        $message = "Passenger already in $stsval.";
        return response()->json(['status' => 300, 'message' => $message, 'stsval' => $stsval, 'id' => $request->id]);
    }

    $client->status = $request->status;

    if ($client->save()) {

        // If setting to Processing (1) — create a sales transaction
        if ($request->status == 1) {
            $tran = new Transaction();
            $tran->date = date('Y-m-d');
            $tran->tran_type = "package_sales";
            $tran->payment_type = "Receivable";
            $tran->bdt_amount = $client->package_cost;
            $tran->user_id = $client->user_id;
            $tran->client_id = $client->id;
            $tran->ref = "Package ". $client->passport_name . " (".$client->passport_number.")";
            $tran->save();
            $tran->tran_id = 'VS' . date('ymd') . str_pad($tran->id, 4, '0', STR_PAD_LEFT);
            $tran->save();
        }

        // If changing from Processing (1) to Decline (4) — cancel and add decline charge
        if ($oldStatus == 1 && $request->status == 4) {
            Transaction::where('client_id', $client->id)
                ->where('tran_type', 'package_sales')
                ->update(['status' => 2]);

            $tran = new Transaction();
            $tran->date = date('Y-m-d');
            $tran->tran_type = "package_adon";
            $tran->payment_type = "Receivable";
            $tran->bdt_amount = $request->decline_charge;
            $tran->user_id = $client->user_id;
            $tran->client_id = $client->id;
            $tran->ref = "Package Cancel ". $client->passport_name . " (".$client->passport_number.")";
            $tran->save();
            $tran->tran_id = 'VC' . date('ymd') . str_pad($tran->id, 4, '0', STR_PAD_LEFT);
            $tran->save();
        }

        // Determine new status label
        $stsval = match($client->status) {
            0 => "New",
            1 => "Processing",
            2 => "Complete",
            3 => "Decline",
            4 => "Visa Cancel",
            default => "Something is wrong"
        };

        return response()->json(['status' => 300, 'message' => "Status Change Successfully.", 'stsval' => $stsval, 'id' => $client->id]);
    } else {
        return response()->json(['status' => 303, 'message' => "There was an error to change status!!"]);
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
