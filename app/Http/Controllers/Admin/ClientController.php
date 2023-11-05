<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
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
        return view('admin.client.index', compact('data','agents','countries','accounts'));
    }

    public function getClientInfo($id)
    {
        $data = Client::where('id',$id)->first();
        $agents = User::where('is_type','2')->get();
        $countries = Country::orderby('id','DESC')->get();
        $accounts = Account::orderby('id','DESC')->get();
        return view('admin.client.clientdetail', compact('data','agents','countries','accounts'));
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
        $data->account_id = $request->account_id;
        $data->package_cost = $request->package_cost;
        $data->total_rcv = $request->total_rcv;
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


}
