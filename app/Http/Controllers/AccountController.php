<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\Account;
use App\Http\Controllers\Controller;
Use Image;
use Illuminate\support\Facades\Auth;

class AccountController extends Controller
{
    public function store(Request $request)
    {
        $data = new Account();
        $data->user_id = $request->uid;
        $data->photo_id = $request->dataid;
        $data->date = $request->date;
        $data->particular = $request->particular;
        $data->category = $request->category;
        $data->amount = $request->amount;
        $data->vat = $request->vat;
        $data->expense = $request->expense;
        $data->income = $request->income;
        $data->others = $request->others;
        $data->net = $request->net;
        $data->status = "0";
        $data->created_by = Auth::user()->id;
        if ($data->save()) {

            $imgupdate = Photo::find($request->dataid);
            $imgupdate->status = "1";
            $imgupdate->save();
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Created Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        } else {
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }

    public function edit($id)
    {
        $info = Account::where('id',$id)->first();
        // dd($data);
        return response()->json($info);
    }

    public function update(Request $request)
    {
        $data = Account::find($request->dataid);
        $data->user_id = $request->uid;
        $data->date = $request->date;
        $data->particular = $request->particular;
        $data->category = $request->category;
        $data->amount = $request->amount;
        $data->vat = $request->vat;
        $data->expense = $request->expense;
        $data->income = $request->income;
        $data->others = $request->others;
        $data->net = $request->net;
        $data->updated_by = Auth::user()->id;
        if ($data->save()) {

            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Updated Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        } else {
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }
}
