<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Okala;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class OkalaController extends Controller
{
    public function index()
    {
        $data = Okala::orderby('id','DESC')->get();
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
        
        for ($i = 0; $i < $x; $i++) {
            $data = new Okala();
            $data->date = $request->date;
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

    public function edit($id)
    {
        $where = [
            'id'=>$id
        ];
        $info = Vendor::where($where)->get()->first();
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
        
        $duplicateemail = Vendor::where('email',$request->email)->where('id','!=', $request->codeid)->first();
        if($duplicateemail){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>This email already added.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }


        $data = Vendor::find($request->codeid);
        $data->name = $request->name;
        $data->address = $request->address;
        $data->phone = $request->phone;
        $data->email = $request->email;
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
        
        $okala = Okala::where('vendor_id', $id)->first();

        if (isset($okala)) {
            return response()->json(['success'=>true,'message'=>'This vendor have transaction. Do not delete this vendor..']);
        } else {
            if(Vendor::destroy($id)){
                return response()->json(['success'=>true,'message'=>'Agent has been deleted successfully']);
            }else{
                return response()->json(['success'=>false,'message'=>'Delete Failed']);
            }
        }
        
    }
}
