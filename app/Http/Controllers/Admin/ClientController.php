<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\BusinessPartner;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Client;
use App\Models\Country;
use App\Models\Transaction;
// use Illuminate\Http\Response;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index()
    {
        $data = Client::where('is_job','1')->orderby('id','DESC')->get();
        $agents = User::where('is_type','2')->where('status', 1)->get();
        $countries = Country::orderby('id','DESC')->get();
        $accounts = Account::orderby('id','DESC')->get();
        $bpartners = BusinessPartner::orderby('id','DESC')->get();
        return view('admin.client.index', compact('data','agents','countries','accounts','bpartners'));
    }

    public function processing()
    {
        $data = Client::where('is_job','1')->where('status','0')->orderby('id','DESC')->get();
        $agents = User::where('is_type','2')->where('status', 1)->get();
        $countries = Country::orderby('id','DESC')->get();
        $accounts = Account::orderby('id','DESC')->get();
        $bpartners = BusinessPartner::orderby('id','DESC')->get();
        return view('admin.client.processing', compact('data','agents','countries','accounts','bpartners'));
    }

    public function decline()
    {
        $data = Client::where('is_job','1')->where('status','2')->orderby('id','DESC')->get();
        $agents = User::where('is_type','2')->where('status', 1)->get();
        $countries = Country::orderby('id','DESC')->get();
        $accounts = Account::orderby('id','DESC')->get();
        $bpartners = BusinessPartner::orderby('id','DESC')->get();
        return view('admin.client.decline', compact('data','agents','countries','accounts','bpartners'));
    }

    public function completed()
    {
        $data = Client::where('is_job','1')->where('status','1')->orderby('id','DESC')->get();
        $agents = User::where('is_type','2')->where('status', 1)->get();
        $countries = Country::orderby('id','DESC')->get();
        $accounts = Account::orderby('id','DESC')->get();
        $bpartners = BusinessPartner::orderby('id','DESC')->get();
        return view('admin.client.completed', compact('data','agents','countries','accounts','bpartners'));
    }



    // ksa without job start
    public function withoutjobindex()
    {
        $data = Client::where('is_job','0')->orderby('id','DESC')->get();
        $agents = User::where('is_type','2')->where('status', 1)->get();
        $countries = Country::orderby('id','DESC')->get();
        $accounts = Account::orderby('id','DESC')->get();
        $bpartners = BusinessPartner::orderby('id','DESC')->get();
        return view('admin.withoutjobclient.index', compact('data','agents','countries','accounts','bpartners'));
    }

    public function withoutjobprocessing()
    {
        $data = Client::where('is_job','0')->where('status','0')->orderby('id','DESC')->get();
        $agents = User::where('is_type','2')->where('status', 1)->get();
        $countries = Country::orderby('id','DESC')->get();
        $accounts = Account::orderby('id','DESC')->get();
        $bpartners = BusinessPartner::orderby('id','DESC')->get();
        return view('admin.withoutjobclient.processing', compact('data','agents','countries','accounts','bpartners'));
    }

    public function withoutjobdecline()
    {
        $data = Client::where('is_job','0')->where('status','2')->orderby('id','DESC')->get();
        $agents = User::where('is_type','2')->where('status', 1)->get();
        $countries = Country::orderby('id','DESC')->get();
        $accounts = Account::orderby('id','DESC')->get();
        $bpartners = BusinessPartner::orderby('id','DESC')->get();
        return view('admin.withoutjobclient.decline', compact('data','agents','countries','accounts','bpartners'));
    }

    public function withoutjobcompleted()
    {
        $data = Client::where('is_job','0')->where('status','1')->orderby('id','DESC')->get();
        $agents = User::where('is_type','2')->where('status', 1)->get();
        $countries = Country::orderby('id','DESC')->get();
        $accounts = Account::orderby('id','DESC')->get();
        $bpartners = BusinessPartner::orderby('id','DESC')->get();
        return view('admin.withoutjobclient.completed', compact('data','agents','countries','accounts','bpartners'));
    }
    // ksa without job end

    public function getClientInfo($id)
    {
        $data = Client::where('id',$id)->first();
        $recepts = Transaction::where('client_id',$id)->where('tran_type','receipt')->orderby('id','DESC')->get();
        $payments = Transaction::where('client_id',$id)->where('tran_type','payment')->orderby('id','DESC')->get();
        // dd($data);
        $agents = User::where('is_type','2')->where('status', 1)->get();
        $countries = Country::orderby('id','DESC')->get();
        $accounts = Account::orderby('id','DESC')->get();
        $bpartners = BusinessPartner::orderby('id','DESC')->get();
        return view('admin.client.clientdetail', compact('data','agents','countries','accounts','bpartners','recepts','payments'));
    }

    public function store(Request $request)
    {
        if(empty($request->user_id)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Agent \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        // if(empty($request->balance)){
        //     $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Balance \" field..!</b></div>";
        //     return response()->json(['status'=> 303,'message'=>$message]);
        //     exit();
        // }

        
        $chkemail = Client::where('clientid',$request->clientid)->whereNotNull('clientid')->first();
        if($chkemail){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>This client ID already added.</b></div>";
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
        $data->due_amount = $request->package_cost - $request->total_rcv;
        $data->description = $request->description;
        $data->is_job = $request->is_job ?? 1;

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

        
        // if(empty($request->name)){
        //     $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Username \" field..!</b></div>";
        //     return response()->json(['status'=> 303,'message'=>$message]);
        //     exit();
        // }
        // if(empty($request->balance)){
        //     $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Balance \" field..!</b></div>";
        //     return response()->json(['status'=> 303,'message'=>$message]);
        //     exit();
        // }

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

        if ($request->flight_date) {
            $data->status = 1;
        }

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

        // image
        if ($request->visa_image != 'null') {
            $request->validate([
                'visa_image' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:8048',
            ]);
            $rand = mt_rand(100000, 999999);
            $visaImageName = time(). $rand .'.'.$request->visa_image->extension();
            $request->visa_image->move(public_path('images/client/visa'), $visaImageName);
            $data->visa = $visaImageName;
        }
        // end

        // image
        if ($request->manpower_image != 'null') {
            $request->validate([
                'manpower_image' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:8048',
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
            return response()->json(['status'=> 300,'message'=>$message]);
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
        $user->status = $request->status;
        if($user->save()){
            if ($user->status == 0) {
                $stsval = "Processing";
            }elseif($user->status == 1){
                $stsval = "Complete";
            }else {
                $stsval = "Decline";
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
