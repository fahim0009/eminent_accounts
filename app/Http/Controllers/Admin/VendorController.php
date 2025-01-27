<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OkalaPurchase;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class VendorController extends Controller
{
    public function index()
    {
        $data = User::where('is_type', 3)->get();
        return view('admin.vendor.index', compact('data'));

    }

    public function store(Request $request)
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
        
        $chkemail = User::where('email',$request->email)->first();
        if($chkemail){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>This email already added.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        $data = new User;
        $data->name = $request->name;
        $data->surname = $request->name;
        $data->address = $request->address;
        $data->phone = $request->phone;
        $data->email = $request->email;
        $data->password = Hash::make("123456");
        $data->is_type = 3;
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
        
        $duplicateemail = User::where('email',$request->email)->where('id','!=', $request->codeid)->first();
        if($duplicateemail){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>This email already added.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }


        $data = User::find($request->codeid);
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
        
        $okala = OkalaPurchase::where('vendor_id', $id)->first();

        if (isset($okala)) {
            return response()->json(['success'=>true,'message'=>'This vendor have transaction. Do not delete this vendor..']);
        } else {
            if(User::destroy($id)){
                return response()->json(['success'=>true,'message'=>'Agent has been deleted successfully']);
            }else{
                return response()->json(['success'=>false,'message'=>'Delete Failed']);
            }
        }
        
    }

    public function updateStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->status = $request->status;
        $user->save();

        return response()->json(['status' => 200, 'message' => 'Status updated successfully.']);
    }

    public function vendorHistory($id)
    {
        $vendor = User::with('okalaPurchase')->where('is_type', 3)->where('id', $id)->first();
        
        $okalaPurchase = OkalaPurchase::with('okalaPurchaseDetail')->where('user_id', $id)->orderby('id','DESC')->get();

        $trans = Transaction::where('user_id',$id)->orderby('id', 'ASC')->get();
        $drAmount = Transaction::where('user_id',$id)->where('tran_type', 'okala_received')->sum('bdt_amount');
        $crAmount = Transaction::where('user_id',$id)->where('tran_type', 'okala_purchase')->sum('bdt_amount');
        $balance =  $crAmount - $drAmount;


        return view('admin.vendor.history', compact('okalaPurchase','vendor','id', 'trans','balance'));

    }
}
