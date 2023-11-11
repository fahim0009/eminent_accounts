<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\BusinessPartner;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Client;
use App\Models\Country;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index()
    {
        $data = Client::orderby('id','DESC')->get();
        $agents = User::where('is_type','2')->get();
        $countries = Country::orderby('id','DESC')->get();
        $accounts = Account::orderby('id','DESC')->get();
        $bpartners = BusinessPartner::orderby('id','DESC')->get();
        return view('admin.client.index', compact('data','agents','countries','accounts','bpartners'));
    }

    public function decline()
    {
        $data = Client::where('decline','1')->orderby('id','DESC')->get();
        $agents = User::where('is_type','2')->get();
        $countries = Country::orderby('id','DESC')->get();
        $accounts = Account::orderby('id','DESC')->get();
        $bpartners = BusinessPartner::orderby('id','DESC')->get();
        return view('admin.client.decline', compact('data','agents','countries','accounts','bpartners'));
    }

    public function completed()
    {
        $data = Client::where('complete','1')->orderby('id','DESC')->get();
        $agents = User::where('is_type','2')->get();
        $countries = Country::orderby('id','DESC')->get();
        $accounts = Account::orderby('id','DESC')->get();
        $bpartners = BusinessPartner::orderby('id','DESC')->get();
        return view('admin.client.completed', compact('data','agents','countries','accounts','bpartners'));
    }

    public function getClientInfo($id)
    {
        $data = Client::where('id',$id)->first();
        // dd($data);
        $agents = User::where('is_type','2')->get();
        $countries = Country::orderby('id','DESC')->get();
        $accounts = Account::orderby('id','DESC')->get();
        $bpartners = BusinessPartner::orderby('id','DESC')->get();
        return view('admin.client.clientdetail', compact('data','agents','countries','accounts','bpartners'));
    }

    public function store(Request $request)
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

        $data = new Client;
        $data->user_id = $request->user_id;
        $data->passport_number = $request->passport_number;
        $data->passport_name = $request->passport_name;
        $data->passport_rcv_date = $request->passport_rcv_date;
        $data->country_id = $request->country;
        $data->account_id = $request->account_id;
        $data->package_cost = $request->package_cost;
        $data->total_rcv = $request->total_rcv;
        $data->due_amount = $request->package_cost - $request->total_rcv;
        $data->description = $request->description;

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

        


        $data = Client::find($request->codeid);
        $data->user_id = $request->user_id;
        $data->passport_number = $request->passport_number;
        $data->passport_name = $request->passport_name;
        $data->passport_rcv_date = $request->passport_rcv_date;
        $data->country_id = $request->country;
        $data->package_cost = $request->package_cost;
        $data->description = $request->description;
        $data->flight_date = $request->flight_date;

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

    // public function delete($id)
    // {

    //     if(Client::destroy($id)){
    //         return response()->json(['success'=>true,'message'=>'Data has been deleted successfully']);
    //     }else{
    //         return response()->json(['success'=>false,'message'=>'Delete Failed']);
    //     }
    // }


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
        $data->b2b_payment = $request->b2b_contact;
        $data->updated_by = Auth::user()->id;
        if ($data->save()) {
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Business Partner Updated Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }
        else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        } 
    }

    public function completeClient(Request $request)
    {
        $user = Client::find($request->id);
        $user->complete = $request->complete;
        $user->save();

        if($request->complete==1){
            $user = Client::find($request->id);
            $user->complete = $request->complete;
            $user->save();
            $message ="Client Complete Successfully.";
            return response()->json(['status'=> 300,'message'=>$message]);
        }else{
            $user = Client::find($request->id);
            $user->complete = $request->complete;
            $user->save();
            $message ="Client not completed!!.";
            return response()->json(['status'=> 303,'message'=>$message]);
        }

    }

    public function declineClient(Request $request)
    {
        $user = Client::find($request->id);
        $user->decline = $request->decline;
        $user->save();

        if($request->decline==1){
            $user = Client::find($request->id);
            $user->decline = $request->decline;
            $user->save();
            $message ="Client decline Successfully.";
            return response()->json(['status'=> 300,'message'=>$message]);
        }else{
            $user = Client::find($request->id);
            $user->decline = $request->decline;
            $user->save();
            $message ="Client not decline!!.";
            return response()->json(['status'=> 303,'message'=>$message]);
        }

    }


}
