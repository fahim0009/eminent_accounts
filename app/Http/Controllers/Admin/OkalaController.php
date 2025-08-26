<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\OkalaPurchase;
use App\Models\OkalaPurchaseDetail;
use App\Models\OkalaSale;
use App\Models\OkalaSaleDetail;
use App\Models\CodeMaster;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class OkalaController extends Controller
{
public function index()
{
    // Only unassigned details
    $data = DB::table('okala_purchase_details as opd')
        ->join('okala_purchases as op', 'opd.okala_purchase_id', '=', 'op.id')
        ->leftJoin('code_masters as trade', 'op.trade', '=', 'trade.id')
        ->leftJoin('code_masters as rl', 'op.r_l_detail_id', '=', 'rl.id')
        ->leftJoin('users as u', 'op.user_id', '=', 'u.id') // vendor
        ->whereNull('opd.assign_to')
        ->orderByDesc('opd.id')
        ->select([
            'opd.id',
            'opd.date',
            'opd.visa_id',
            'opd.sponsor_id',
            'opd.user_id',        // for vendor lookup if needed
            'opd.r_l_detail_id',  // original field
            'opd.okala_purchase_id',
            'trade.type_name as trade_name',
            'rl.type_name as rl_name',
            'u.name as vendor_name',
        ])
        ->get();

    // Clients to assign (once, not per-row)
    $clients = \App\Models\Client::select('id','passport_name','passport_number')
        ->where('assign', 0)->where('status', 1)->orderByDesc('id')->get();

    return view('admin.okala.index', compact('data','clients'));
}

    public function myOkalagroup()
    {
    // Base query with a proper correlated subquery for assigned_count
    $base = DB::table('okala_purchases as op')
        ->leftJoin('code_masters as cm', 'op.r_l_detail_id', '=', 'cm.id')
        ->leftJoin('users as u', 'op.user_id', '=', 'u.id')
        ->where('op.purchase_type', 0)
        ->select([
            'op.*',
            'cm.type_name',
            'u.name as vendor_name',
        ])
        ->selectSub(function ($q) {
            $q->from('okala_purchase_details as opd')
              ->selectRaw('COUNT(*)')
              ->whereColumn('opd.okala_purchase_id', 'op.id')
              ->whereNotNull('opd.assign_to');
        }, 'assigned_count')
        ->orderByDesc('op.id');

    // Pull rows, then compute "available" in PHP (safe & simple)
    $rows = $base->get()->map(function ($row) {
        // make sure numeric types
        $row->number          = (int) $row->number;
        $row->assigned_count  = (int) $row->assigned_count;
        $row->available       = $row->number - $row->assigned_count;
        return $row;
    });

    // Split for tabs
    $data     = $rows->filter(fn ($r) => $r->available > 0)->values(); // Processing
    $complete = $rows->filter(fn ($r) => $r->available === 0)->values(); // Completed

    return view('admin.okala.myokala', compact('data', 'complete'));
    }
    
    public function okalaPurchase()
    {
        $data = OkalaPurchase::orderby('id','DESC')->get();
        $complete = OkalaPurchase::orderby('id','DESC')->where('status', 1)->get();
        return view('admin.okala.purchase', compact('data','complete'));
    }

    public function okalapurchaseDetails($id)
    {

        $data = DB::table('okala_purchase_details')
        ->leftJoin('clients', 'okala_purchase_details.assign_to', '=', 'clients.id')
        ->where('okala_purchase_details.okala_Purchase_id', $id)
        ->orderBy('okala_purchase_details.id', 'DESC')
        ->select(
            'okala_purchase_details.*', 
            'clients.passport_name', 
            'clients.passport_number'
        )
        ->get();
        return view('admin.okala.index', compact('data'));
    }

    public function assignedOkala()
    {

        $data = DB::table('okala_purchase_details')
        ->join('clients', 'okala_purchase_details.assign_to', '=', 'clients.id')
        ->join('okala_purchases', 'okala_purchases.id', '=', 'okala_purchase_details.okala_purchase_id')
        ->leftJoin('users', 'clients.user_id', '=', 'users.id')
        ->leftJoin('code_masters as mofa_cm', 'mofa_cm.id', '=', 'okala_purchases.trade')
        ->leftJoin('code_masters as rl_cm', 'rl_cm.id', '=', 'okala_purchases.r_l_detail_id')
        ->whereNotNull('okala_purchase_details.assign_to')
        ->orderBy('okala_purchase_details.id', 'DESC')
        ->select(
            'okala_purchase_details.*', 
            'clients.passport_name', 
            'clients.passport_number',
            'mofa_cm.type_name as mofa',
            'rl_cm.type_name as rl',
             'users.name as agent_name', 
             'users.surname as agent_surname'
        )
        ->get();
        
        return view('admin.okala.assignedokala', compact('data'));
    }

    public function store(Request $request)
    {
        if(empty($request->date)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Date \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->datanumber)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Number Of Okala \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->visaid)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Visa id \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(empty($request->sponsorid)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Sponsor Id \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->r_l_detail_id)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please Select \"RL \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->trade)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please Select \"Trade \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->bdt_amount)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please Fill \"BDT Amount \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        
        $x = $request->datanumber;
        $okala = new OkalaPurchase();
        $okala->date = $request->date;
        $okala->number = $x;
        $okala->user_id = $request->user_id;
        $okala->sponsorid = $request->sponsorid;
        $okala->visaid = $request->visaid;
        $okala->riyal_amount = $request->riyal_amount;
        $okala->bdt_amount = $request->bdt_amount;
        $okala->total_riyal = $request->riyal_amount * $x;
        $okala->total_bdt = $request->bdt_amount * $x;
        $okala->purchase_type = $request->purchase_type;
        $okala->trade = $request->trade;
        $okala->r_l_detail_id = $request->r_l_detail_id;
        $okala->created_by = Auth::user()->id;
        $okala->save();
        
        if($request->purchase_type == 0){

        for ($i = 0; $i < $x; $i++) {
            $data = new OkalaPurchaseDetail();
            $data->okala_purchase_id  = $okala->id;
            $data->date = $request->date;
            $data->user_id = $request->user_id;
            $data->sponsor_id = $request->sponsorid;
            $data->visa_id = $request->visaid;
            $data->r_l_detail_id = $request->r_l_detail_id;
            $data->created_by = Auth::user()->id;
            $data->save();
        }
    }
        $tran = new Transaction();
        $tran->date = $request->date;
        $tran->user_id = $request->user_id;
        $tran->tran_type = $request->tran_type;
        $tran->note =  null;
        $tran->okala_purchase_id  = $okala->id;
        $tran->foreign_amount =  $request->riyal_amount * $x;
        $tran->foreign_amount_type =  'riyal';
        $tran->bdt_amount = $request->bdt_amount * $x;
        $tran->payment_type = "Payable";
        $tran->ref = "Okala Purchase";
        $tran->created_by = Auth::user()->id;
        $tran->save();
        $tran->tran_id = 'OKP' . date('ymd') . str_pad($tran->id, 4, '0', STR_PAD_LEFT);
        $tran->save();
       
        $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Okala Purchase Create Successfully.</b></div>";
        return response()->json(['status'=> 300,'message'=>$message]);
        
    }

    public function edit($id)
    {
        $where = [
            'id'=>$id
        ];
        $info = OkalaPurchaseDetail::where($where)->get()->first();
        return response()->json($info);
    }

    public function update(Request $request)
    {

        
        if(empty($request->date)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Date \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(empty($request->visaid)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Visa id \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(empty($request->sponsorid)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Sponsor Id \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }


        
        $data = OkalaPurchaseDetail::find($request->codeid);
        $data->date = $request->date;
        $data->user_id = $request->user_id;
        $data->vendor_id = $request->vendor_id;
        $data->trade = $request->trade;
        $data->sponsorid = $request->sponsorid;
        $data->visaid = $request->visaid;
        $data->r_l_detail_id = $request->r_l_detail_id;
        $data->created_by = Auth::user()->id;
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
        
        $okala = OkalaPurchaseDetail::where('id', $id)->first();

        if (isset($okala->assign_to)) {
            return response()->json(['success'=>true,'message'=>'This Okala have transaction. Do not delete this Okala..']);
        } else {
            if(OkalaPurchaseDetail::destroy($id)){
                return response()->json(['success'=>true,'message'=>'Okala has been deleted successfully']);
            }else{
                return response()->json(['success'=>false,'message'=>'Delete Failed']);
            }
        }
        
    }


    public function addClientToOkala(Request $request)
    {

        $data = OkalaPurchaseDetail::find($request->okalaId);
        if (!$data) {
            return response()->json(['status' => 303, 'message' => 'Okala record not found.']);
        }
        $data->assign_to = $request->clientId;
        $data->assign_date = now();
        $data->save();

        $client = Client::find($request->clientId);
        $client->assign = 1;

        if ($client->save()) {
            $message ="Status Change Successfully.";
            return response()->json(['status'=> 300,'message'=>$message]);
        }
        else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }



    // okala sales

    public function salesindex()
    {
        // Details table (if you actually render it elsewhere)
        $data = \App\Models\OkalaSaleDetail::orderByDesc('id')->get();

        // Main list with proper joins & aliases
        $okala_sales = DB::table('okala_sales as os')
            ->join('okala_purchases as op', 'os.okala_purchase_id', '=', 'op.id')
            ->leftJoin('users as v', 'op.user_id', '=', 'v.id')   // vendor (from purchase)
            ->leftJoin('users as a', 'os.user_id', '=', 'a.id')   // agent (who sold)
            ->leftJoin('code_masters as rl', 'op.r_l_detail_id', '=', 'rl.id')
            ->select([
                'os.*',
                'os.status as sale_status',   // 👈 make it explicit
                'op.visaid',
                'op.sponsorid as sponsor_id',
                'op.number',
                'rl.type_name as rl',
                'v.name as vendor_name',
                'a.name as agent_name',
                'a.surname as agent_surname',
            ])
            ->orderByDesc('os.id')
            ->get();

        // Split for tabs using the aliased sale_status
        $processing = $okala_sales->where('sale_status', 0)->values();
        $completed  = $okala_sales->where('sale_status', 1)->values();

        return view('admin.okala.sales', compact('data','okala_sales','processing','completed'));
    }

    public function salesDetails($id)
    {
        $data = OkalaSaleDetail::where('okala_sale_id', $id)->orderby('id','DESC')->get();
        return view('admin.okala.salesdetails', compact('data'));
    }



    public function salesstore(Request $request)
    {
        if(empty($request->date)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Date \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        
        $purchaseData = OkalaPurchase::where('id', $request->okalaNo)->first();
        $x = $purchaseData->number;
        $okala = new OkalaSale();
        $okala->date = $request->date;
        $okala->okala_purchase_id  = $request->okalaNo;
        $okala->number = $x;
        $okala->user_id = $request->agentId;
        $okala->r_l_detail_id = $purchaseData->r_l_detail_id;
        $okala->visaid = $purchaseData->visaid;
        $okala->sponsor_id = $purchaseData->sponsorid;
        $okala->trade = $purchaseData->trade;
        $okala->bdt_amount = $request->sales_bdt_amount*$x;
        $okala->riyal_amount = $request->sales_riyal_amount*$x;
        $okala->created_by = Auth::user()->id;
        $okala->save();
        
        for ($i = 0; $i < $x; $i++) {
            $data = new OkalaSaleDetail();
            $data->date = $request->date;
            $data->okala_sale_id  = $okala->id;
            $data->user_id = $request->agentId;
            $data->r_l_detail_id = $purchaseData->r_l_detail_id;
            $data->visaid = $purchaseData->visaid;
            $data->sponsorid = $purchaseData->sponsorid;
            $data->trade = $purchaseData->trade;
            $data->bdt_amount = $request->sales_bdt_amount;
            $data->riyal_amount = $request->sales_riyal_amount;

            $data->created_by = Auth::user()->id;
            $data->save();
        }

        $tran = new Transaction();
        $tran->date = $request->date;
        $tran->user_id = $request->agentId;
        $tran->tran_type = $request->tran_type;
        $tran->ref = "Okala Sales";
        $tran->note = "(".$x." ".$typeName = CodeMaster::where('id', $purchaseData->trade)->first()->type_name.")";
        $tran->okala_sale_id  = $okala->id;
        $tran->foreign_amount =  $request->sales_riyal_amount * $x;
        $tran->foreign_amount_type =  'riyal';
        $tran->bdt_amount = $request->sales_bdt_amount * $x;
        $tran->payment_type = "receivable";
        $tran->created_by = Auth::user()->id;
        $tran->save();
        $tran->tran_id = 'OKS' . date('ymd') . str_pad($tran->id, 4, '0', STR_PAD_LEFT);
        $tran->save();

        $data = OkalaPurchase::find($request->okalaNo);
        $data->status = 1;
        $data->created_by = Auth::user()->id;
        $data->save();

        $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Create Successfully.</b></div>";
        return response()->json(['status'=> 300,'message'=>$message]);
        
    }

    public function salesedit($id)
    {
        $where = [
            'id'=>$id
        ];
        $info = OkalaSale::where($where)->get()->first();
        return response()->json($info);
    }

    public function salesupdate(Request $request)
    {

        
        if(empty($request->date)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Date \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(empty($request->visaid)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Visa id \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(empty($request->sponsorid)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Sponsor Id \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }


        
        $data = OkalaSale::find($request->codeid);
        $data->date = $request->date;
        $data->user_id = $request->user_id;
        $data->vendor_id = $request->vendor_id;
        $data->trade = $request->trade;
        $data->sponsorid = $request->sponsorid;
        $data->visaid = $request->visaid;
        $data->created_by = Auth::user()->id;
        if ($data->save()) {
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Updated Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }
        else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        } 
    }

    public function salesdelete($id)
    {
       
        if(OkalaSale::destroy($id)){
            return response()->json(['success'=>true,'message'=>'Okala has been deleted successfully']);
        }else{
            return response()->json(['success'=>false,'message'=>'Delete Failed']);
        }
        
    }

    public function changeOkalaSalesStatus(Request $request)
    {
        $user = OkalaSale::find($request->id);
        $user->status = $request->status;
        if($user->save()){

            if ($user->status == 0) {
                $stsval = "New";
            }elseif($user->status == 1){
                $stsval = "Processing";
            }elseif($user->status == 2){
                $stsval = "Complete";
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

    public function changeOkalapurchaseStatus(Request $request)
    {
        $user = OkalaPurchase::find($request->id);
        $user->status = $request->status;
        if($user->save()){

            if ($user->status == 0) {
                $stsval = "New";
            }elseif($user->status == 1){
                $stsval = "Processing";
            }elseif($user->status == 2){
                $stsval = "Complete";
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
}
