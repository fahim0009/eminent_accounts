<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    public function index()
    {
        $data = Loan::orderby('id','DESC')->get();
        $accounts = Account::orderby('id','DESC')->get();
        $agents = User::where('is_type','2')->orderby('id','DESC')->get();
        return view('admin.loan.index', compact('data','agents','accounts'));
    }

    public function store(Request $request)
    {
        if(empty($request->date)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Date \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(empty($request->user_id)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Agent \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(empty($request->amount)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Amount \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        
        $data = new Loan;
        $data->date = $request->date;
        $data->user_id = $request->user_id;
        $data->account_id = $request->account_id;
        $data->amount = $request->amount;
        $data->due_amount = $request->amount;
        $data->note = $request->note;
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
        $info = Loan::where($where)->get()->first();
        return response()->json($info);
    }

    public function update(Request $request)
    {

        
        if(empty($request->date)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Date \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(empty($request->user_id)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Agent \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(empty($request->amount)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Amount \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }



        $data = Loan::find($request->codeid);
        $data->date = $request->date;
        $data->user_id = $request->user_id;
        $data->account_id = $request->account_id;
        $data->amount = $request->amount;
        $data->note = $request->note;
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

        if(Loan::destroy($id)){
            return response()->json(['success'=>true,'message'=>'Data has been deleted successfully']);
        }else{
            return response()->json(['success'=>false,'message'=>'Delete Failed']);
        }
    }
}
