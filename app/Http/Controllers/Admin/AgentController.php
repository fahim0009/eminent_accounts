<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Client;
use App\Models\CodeMaster;
use App\Models\Country;
use App\Models\Loan;
use App\Models\LoanTransaction;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AgentController extends Controller
{
    public function index()
    {
        $data = User::where('is_type', '2')->orderby('id','DESC')->get();
        return view('admin.agent.index', compact('data'));
    }

    public function getClient($id)
    {
        $data = Client::where('user_id', $id)->orderby('id','DESC')->get();

        //  ############################ start visa & service sales calculation  ######################################

        $processing = Client::where('status','1')->where('user_id', $id)->count();
        $decline = Client::where('status','3')->where('user_id', $id)->count();
        $completed = Client::where('status','2')->where('user_id', $id)->count();

// total package amout with extara charge if added 
        $totalPackageAmount = Transaction::where('user_id', $id)
                            ->whereIn('tran_type', ['package_sales', 'package_adon'])
                            ->sum('bdt_amount');

// processing package amout with extara charge if added 
        $processingPackageAmount = DB::table('transactions')
            ->join('clients', 'transactions.client_id', '=', 'clients.id')  // Join the tables
            ->where('clients.status', 1)
            ->where('transactions.user_id', $id)
            ->whereIn('transactions.tran_type', ['package_sales', 'package_adon'])
            ->sum('transactions.bdt_amount');

// completed package amout with extara charge if added 
        $completedPackageAmount = DB::table('transactions')
            ->join('clients', 'transactions.client_id', '=', 'clients.id')  // Join the tables
            ->where('clients.status', 2)
            ->where('transactions.user_id', $id)
            ->whereIn('transactions.tran_type', ['package_sales', 'package_adon'])
            ->sum('transactions.bdt_amount');   

// package discount on total package cost 
        $totalPkgDiscountAmnt = Transaction::where('user_id',$id)->where('tran_type','package_discount')->sum('bdt_amount');

//   total package receive amount 
        $totalPackageReceivedAmnt = Transaction::where('user_id',$id)->where('tran_type','package_received')->sum('bdt_amount');

//  others bill amount like medical contact , embassay extra fees, manpower speed money 
        $totaServiceamt = Transaction::where('user_id',$id)
                        ->whereIn('tran_type', ['service_sales', 'service_adon'])    
                        ->sum('bdt_amount');

//   total service receive amount 
        $totalServiceReceivedAmnt = Transaction::where('user_id',$id)->where('tran_type','service_received')->sum('bdt_amount');                        
 
//   receive amount for running work that is not delivered yet including others bill amount      
        $rcvamntForProcessing = ($totalPackageReceivedAmnt +  $totalPkgDiscountAmnt) - ($completedPackageAmount + $totaServiceamt);

        // $directReceivedAmnt = Transaction::where('user_id',$id)->whereNull('client_id')->where('tran_type','Received')->sum('bdt_amount');

        $dueForvisa = (($totalPackageAmount + $totaServiceamt)  - ($totalPackageReceivedAmnt + $totalPkgDiscountAmnt + $totalServiceReceivedAmnt));

        $totalReceivedAmnt = Transaction::where('user_id', $id)
                            ->whereIn('tran_type', ['package_received', 'service_received', 'okala_received'])
                            ->sum('bdt_amount');

        $agents = User::where('id',$id)->get();
        $countries = CodeMaster::where('type','COUNTRY')->orderby('id','DESC')->get();
        $accounts = Account::orderby('id','DESC')->get();
        return view('admin.agent.client', compact('data','agents','countries','accounts','processing','decline','completed','id','completedPackageAmount','processingPackageAmount','totalPackageAmount','totalReceivedAmnt','rcvamntForProcessing','totaServiceamt','totalPkgDiscountAmnt','dueForvisa'));
    }   


    public function getTran($id)
    {
        $data = Transaction::where('user_id',$id)->orderby('date','DESC')->get();

        return view('admin.agent.tran', compact('data','id'));
    }

    public function store(Request $request)
    {
        if(empty($request->name)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Name \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(empty($request->surname)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Surname \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(empty($request->email)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Email \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(empty($request->phone)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Phone \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(empty($request->password)){            
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Password\" field..!</b></div>"; 
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(isset($request->password) && ($request->password != $request->confirm_password)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Password doesn't match.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        $chkemail = User::where('email',$request->email)->first();
        if($chkemail){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>This email already added.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        $data = new User;
        $data->name = $request->name;
        $data->surname = $request->surname;
        $data->phone = $request->phone;
        $data->email = $request->email;
        $data->house_number = $request->house_number;
        $data->street_name = $request->street_name;
        $data->town = $request->town;
        $data->is_type = "2";
        $data->postcode = $request->postcode;
        if(isset($request->password)){
            $data->password = Hash::make($request->password);
        }
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
        $info = User::where($where)->get()->first();
        return response()->json($info);
    }

    public function update(Request $request)
    {

        
        if(empty($request->name)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Username \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(empty($request->email)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Email \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(empty($request->phone)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Phone \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        
        if(isset($request->password) && ($request->password != $request->confirm_password)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Password doesn't match.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        $duplicateemail = User::where('email',$request->email)->where('id','!=', $request->codeid)->first();
        if($duplicateemail){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>This email already added.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }


        $data = User::find($request->codeid);
        $data->name = $request->name;
        $data->surname = $request->surname;
        $data->phone = $request->phone;
        $data->email = $request->email;
        $data->house_number = $request->house_number;
        $data->street_name = $request->street_name;
        $data->town = $request->town;
        $data->postcode = $request->postcode;
        if(isset($request->password)){
            $data->password = Hash::make($request->password);
        }
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
        $chkagent = Client::where('user_id', $id)->first();
        $chktran = Transaction::where('user_id', $id)->first();
        $chkloan = Loan::where('user_id', $id)->first();

        if (isset($chkagent) || isset($chktran) || isset($chkloan)) {

            return response()->json(['success'=>true,'message'=>'This agent have transaction. Do not delete this agent..']);

        } else {
            if(User::destroy($id)){
                return response()->json(['success'=>true,'message'=>'Agent has been deleted successfully']);
            }else{
                return response()->json(['success'=>false,'message'=>'Delete Failed']);
            }
        }
        

        
    }
}
