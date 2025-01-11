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
        $data = OkalaPurchaseDetail::whereNull('assign_to')->orderby('id','DESC')->get();
        return view('admin.okala.index', compact('data'));
    }

    public function okalaPurchase()
    {
        $data = OkalaPurchase::with('okalaPurchaseDetail')->orderby('id','DESC')->get();
        
        return view('admin.okala.purchase', compact('data'));
    }

    public function okalapurchaseDetails($id)
    {
        
        $data = OkalaPurchaseDetail::where('okala_Purchase_id', $id)->orderby('id','DESC')->get();
        return view('admin.okala.index', compact('data'));
    }

    public function assignedOkala()
    {
        $data = OkalaPurchaseDetail::whereNotNull('assign_to')->orderby('id','DESC')->get();
        
        return view('admin.okala.index', compact('data'));
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
        $data->assign_to = $request->clientId;
        $data->assign_date = now();
        $data->save();

        $client = Client::find($request->clientId);
        $client->assign = 1;
        $client->save();

        return response()->json(['message' => 'Client added successfully!']);
    }



    // okala sales

    public function salesindex()
    {
        $data = OkalaSaleDetail::orderby('id','DESC')->get();
        $okala_sales = DB::table('okala_sales')
                ->join('okala_purchases', 'okala_sales.okala_purchase_id', '=', 'okala_purchases.id')
                ->join('users', 'okala_purchases.user_id', '=', 'users.id')
                ->select('okala_sales.*', 'users.name as vendor_name')
                ->get();
        // $okala_sales= OkalaSale::orderby('id', 'DESC')->get();
        return view('admin.okala.sales', compact('data','okala_sales'));
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
}
