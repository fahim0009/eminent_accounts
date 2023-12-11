<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\BusinessPartner;
use App\Models\Client;
use App\Models\User;
use App\Models\KafelaClient;
use App\Models\Country;
use App\Models\KafelaClientHistory;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

class KafelaClientController extends Controller
{
    public function index()
    {
        $clients = Client::orderby('id','DESC')->get();
        $data = KafelaClient::where('status', 0)->orderby('id','DESC')->get();
        $agents = User::where('is_type','2')->get();
        $countries = Country::orderby('id','DESC')->get();
        $accounts = Account::orderby('id','DESC')->get();
        return view('admin.kafela.index', compact('data','agents','countries','accounts','clients'));
    }

    public function completed()
    {
        $data = KafelaClient::where('status','1')->orderby('id','DESC')->get();
        $agents = User::where('is_type','2')->get();
        $countries = Country::orderby('id','DESC')->get();
        $accounts = Account::orderby('id','DESC')->get();
        $bpartners = BusinessPartner::orderby('id','DESC')->get();
        return view('admin.kafela.completed', compact('data','agents','countries','accounts','bpartners'));
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

        $data = new KafelaClient;
        $data->client_id = $request->client_id;
        $data->job_title = $request->job_title;
        $data->job_company = $request->job_company;
        $data->salary = $request->salary;
        $data->joining_date = $request->joining_date;
        $data->aqama_exp_date = $request->aqama_exp_date;
        $data->description = $request->description;

        // image
        if ($request->aqama_image != 'null') {
            $request->validate([
                'aqama_image' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:8048',
            ]);
            $rand = mt_rand(100000, 999999);
            $passporImageName = time(). $rand .'.'.$request->aqama_image->extension();
            $request->aqama_image->move(public_path('images/client/aqama'), $passporImageName);
            $data->aqama_image = $passporImageName;
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
        $info = KafelaClient::where($where)->get()->first();
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

        
        $data = KafelaClient::find($request->codeid);
        $data->client_id = $request->client_id;
        $data->job_title = $request->job_title;
        $data->job_company = $request->job_company;
        $data->salary = $request->salary;
        $data->joining_date = $request->joining_date;
        $data->aqama_exp_date = $request->aqama_exp_date;
        $data->description = $request->description;

        // image
        if ($request->aqama_image != 'null') {
            $request->validate([
                'aqama_image' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:8048',
            ]);
            $rand = mt_rand(100000, 999999);
            $passporImageName = time(). $rand .'.'.$request->aqama_image->extension();
            $request->aqama_image->move(public_path('images/client/aqama'), $passporImageName);
            $data->aqama_image = $passporImageName;
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

        if(KafelaClient::destroy($id)){
            return response()->json(['success'=>true,'message'=>'Data has been deleted successfully']);
        }else{
            return response()->json(['success'=>false,'message'=>'Delete Failed']);
        }
    }


    public function changeClientStatus(Request $request)
    {
        $user = KafelaClient::find($request->id);

        if ($request->status == 0) {
            $data = new KafelaClientHistory;
            $data->kafela_client_id = $request->id;
            $data->job_title = $user->job_title;
            $data->job_company = $user->job_company;
            $data->salary = $user->salary;
            $data->joining_date = $user->joining_date;
            $data->aqama_exp_date = $user->aqama_exp_date;
            $data->description = $user->description;
            $data->save();

            $user->job_title = Null;
            $user->job_company = Null;
            $user->salary = "0";
            $user->joining_date = Null;
        }

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
            return response()->json(['status'=> 300,'message'=>$message,'stsval'=>$stsval]);
        }else{
            $message ="There was an error to change status!!.";
            return response()->json(['status'=> 303,'message'=>$message]);
        }

    }


}
