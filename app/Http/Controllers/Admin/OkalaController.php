<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Okala;
use App\Models\OkalaDetail;
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
        $okala->number = $request->datanumber;
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
            if(Okala::destroy($id)){
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
}
