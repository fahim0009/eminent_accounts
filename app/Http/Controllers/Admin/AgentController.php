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
        // $data = User::where('is_type', '2')->orderby('id','DESC')->get();
        $data = DB::table('users')
        ->leftJoin('transactions', 'users.id', '=', 'transactions.user_id')
        ->select(
            'users.id',      // Include only necessary columns
            'users.name',
            'users.surname',
            'users.email',   
            'users.phone',   
            'users.status',
            'users.is_type',
            DB::raw('COALESCE(SUM(CASE WHEN transactions.tran_type IN ("package_sales", "package_adon","service_sales","service_adon","okala_sales","okalasales_adon") THEN transactions.bdt_amount ELSE 0 END), 0) as total_receiable'),  
            DB::raw('COALESCE(SUM(CASE WHEN transactions.tran_type IN ("package_received", "package_discount","service_received","service_discount","okala_received","okalasales_discount") THEN transactions.bdt_amount ELSE 0 END), 0) as total_received')
        )
        ->where('users.is_type', '=', '2')
        ->groupBy('users.id', 'users.name', 'users.surname', 'users.email', 'users.phone','users.status','users.is_type',) // Group by all selected columns
        ->get();

        return view('admin.agent.index', compact('data'));
    }

    public function getClient(Request $request, $id)
    {
        // Get Clients with package summary
        $datas = DB::table('clients')
            ->leftJoin('transactions', 'clients.id', '=', 'transactions.client_id')
            ->select(
                'clients.id',
                'clients.passport_name',
                'clients.passport_number',
                'clients.package_cost',
                'clients.status',
                DB::raw('COALESCE(SUM(CASE WHEN transactions.tran_type IN ("package_received", "package_discount") AND transactions.status IN (1, 2) THEN transactions.bdt_amount ELSE 0 END), 0) as total_received'),
                DB::raw('COALESCE(SUM(CASE WHEN transactions.tran_type IN ("package_sales", "package_adon") AND transactions.status IN (1, 2) THEN transactions.bdt_amount ELSE 0 END), 0) as total_package')
            )
            ->where('clients.user_id', $id)
            ->groupBy(
                'clients.id',
                'clients.passport_name',
                'clients.passport_number',
                'clients.package_cost',
                'clients.status'
            )
            ->orderBy('clients.id', 'DESC')
            ->get();
    
    
        // Client status counts
        $processing = Client::where('status', 1)->where('user_id', $id)->count();
        $decline = Client::where('status', 3)->where('user_id', $id)->count();
        $completed = Client::where('status', 2)->where('user_id', $id)->count();
    
        // Package amount totals by status
        $packageAmounts = DB::table('transactions')
            ->join('clients', 'transactions.client_id', '=', 'clients.id')
            ->selectRaw("
                SUM(CASE WHEN clients.status = 1 THEN transactions.bdt_amount ELSE 0 END) as processing,
                SUM(CASE WHEN clients.status = 2 THEN transactions.bdt_amount ELSE 0 END) as completed,
                SUM(CASE WHEN transactions.status = 1 THEN transactions.bdt_amount ELSE 0 END) as total
            ")
            ->where('transactions.user_id', $id)
            ->whereIn('transactions.tran_type', ['package_sales', 'package_adon'])
            ->first();
    
        // Discounts and receives
        $totalPkgDiscountAmnt = Transaction::where('user_id', $id)->where('tran_type', 'package_discount')->sum('bdt_amount');
        $totalPackageReceivedAmnt = Transaction::where('user_id', $id)->where('tran_type', 'package_received')->sum('bdt_amount');
    
        // Service related amounts
        $totaServiceamt = Transaction::where('user_id', $id)
            ->whereIn('tran_type', ['service_sales', 'service_adon'])
            ->sum('bdt_amount');
    
        $totalServiceReceivedAmnt = Transaction::where('user_id', $id)
            ->where('tran_type', 'service_received')
            ->sum('bdt_amount');
    
        // Pending processing amount
        $rcvamntForProcessing = ($totalPackageReceivedAmnt + $totalPkgDiscountAmnt) - ($packageAmounts->completed);
    
        // Total due
        $dueForvisa = ($packageAmounts->total + $totaServiceamt) - ($totalPackageReceivedAmnt + $totalPkgDiscountAmnt + $totalServiceReceivedAmnt);
    
        // Total visa and service received
        $ttlVisanSrvcRcv = Transaction::where('user_id', $id)
            ->whereIn('tran_type', ['package_received', 'service_received'])
            ->sum('bdt_amount');
    
        // Static data
        $agents = User::where('id', $id)->get();
        $countries = CodeMaster::where('type', 'COUNTRY')->orderBy('id', 'DESC')->get();
        $accounts = Account::orderBy('id', 'DESC')->get();
    
        // Filtered transactions by date
        $clientTransactions = Transaction::where('user_id', $id)
                    ->whereIn('status', [1, 2]) // Filter by transaction status
                    ->when($request->from_date, function ($query) use ($request) {
                        $query->where('date', '>=', $request->from_date);
                    })
                    ->when($request->to_date, function ($query) use ($request) {
                        $query->where('date', '<=', $request->to_date);
                    })
                    ->orderBy('date', 'DESC')
                    ->get();
    
    
        return view('admin.agent.client', compact(
            'datas',
            'agents',
            'countries',
            'accounts',
            'processing',
            'decline',
            'completed',
            'id',
            'packageAmounts',
            'ttlVisanSrvcRcv',
            'rcvamntForProcessing',
            'totaServiceamt',
            'totalPkgDiscountAmnt',
            'dueForvisa',
            'clientTransactions'
        ));
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
