<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Okala;
use App\Models\OkalaDetail;
use App\Models\OkalaSale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class OkalaController extends Controller
{
    public function index()
    {
        $data = OkalaDetail::whereNull('assign_to')->orderby('id','DESC')->get();
        return view('admin.okala.index', compact('data'));
    }

    public function okalaPurchase()
    {
        $data = Okala::with('okalaDetail')->orderby('id','DESC')->get();
        return view('admin.okala.purchase', compact('data'));
    }

    public function okalapurchaseDetails($id)
    {
        
        $data = OkalaDetail::where('okala_id', $id)->orderby('id','DESC')->get();
        return view('admin.okala.index', compact('data'));
    }

    public function assignedOkala()
    {
        $data = OkalaDetail::whereNotNull('assign_to')->orderby('id','DESC')->get();
        
        return view('admin.okala.index', compact('data'));
    }

    public function store(Request $request)
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
        
        $x = $request->datanumber;
        $okala = new Okala();
        $okala->date = $request->date;
        $okala->number = $x;
        $okala->vendor_id = $request->vendor_id;
        $okala->sponsorid = $request->sponsorid;
        $okala->visaid = $request->visaid;
        $okala->riyal_amount = $request->riyal_amount;
        $okala->bdt_amount = $request->bdt_amount;
        $okala->total_riyal = $request->riyal_amount * $x;
        $okala->total_bdt = $request->bdt_amount * $x;
        $okala->created_by = Auth::user()->id;
        $okala->save();
        
        for ($i = 0; $i < $x; $i++) {
            $data = new OkalaDetail();
            $data->date = $request->date;
            $data->okala_id = $okala->id;
            $data->user_id = $request->user_id;
            $data->vendor_id = $request->vendor_id;
            $data->trade = $request->trade;
            $data->sponsorid = $request->sponsorid;
            $data->visaid = $request->visaid;
            $data->r_l_detail_id = $request->r_l_detail_id;
            $data->created_by = Auth::user()->id;
            $data->save();
        }
        
        $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Create Successfully.</b></div>";
        return response()->json(['status'=> 300,'message'=>$message]);
        
    }

    public function edit($id)
    {
        $where = [
            'id'=>$id
        ];
        $info = OkalaDetail::where($where)->get()->first();
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


        
        $data = OkalaDetail::find($request->codeid);
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
        
        $okala = OkalaDetail::where('id', $id)->first();

        if (isset($okala->assign_to)) {
            return response()->json(['success'=>true,'message'=>'This Okala have transaction. Do not delete this Okala..']);
        } else {
            if(OkalaDetail::destroy($id)){
                return response()->json(['success'=>true,'message'=>'Okala has been deleted successfully']);
            }else{
                return response()->json(['success'=>false,'message'=>'Delete Failed']);
            }
        }
        
    }


    public function addClientToOkala(Request $request)
    {
        $data = OkalaDetail::find($request->okalaId);
        $data->assign_to = $request->clientId;
        $data->save();

        $client = Client::find($request->clientId);
        $client->assign = 1;
        $client->save();

        return response()->json(['message' => 'Client added successfully!']);
    }



    // okala sales

    public function salesindex()
    {
        $data = OkalaSale::orderby('id','DESC')->get();
        return view('admin.okala.sales', compact('data'));
    }



    public function salesstore(Request $request)
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
        
        $x = $request->datanumber;
        $okala = new Okala();
        $okala->number = $request->datanumber;
        $okala->created_by = Auth::user()->id;
        $okala->save();
        
        for ($i = 0; $i < $x; $i++) {
            $data = new OkalaSale();
            $data->date = $request->date;
            $data->okala_id = $okala->id;
            $data->user_id = $request->user_id;
            $data->vendor_id = $request->vendor_id;
            $data->trade = $request->trade;
            $data->sponsorid = $request->sponsorid;
            $data->visaid = $request->visaid;
            $data->created_by = Auth::user()->id;
            $data->save();
        }
        
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
