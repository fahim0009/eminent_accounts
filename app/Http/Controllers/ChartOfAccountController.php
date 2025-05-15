<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChartOfAccount;
use Illuminate\support\Facades\Auth;

class ChartOfAccountController extends Controller
{
    public function getaccounthead(Request $request)
    {
        $accdtl = ChartOfAccount::where('id', '=', $request->accname)->first();
        if(empty($accdtl)){
            return response()->json(['status'=> 303,'message'=>"No data found"]);
        }else{
                return response()->json(['status'=> 300,'accheadname'=>$accdtl->account_name,'chart_of_account_id'=>$accdtl->id]);
        }
    }

    public function index($office = Null)
    {
        $data = ChartOfAccount::orderby('id','DESC')
                ->when($office, function ($query) use ($office) {
                            $query->where('office', $office);
                        })->get();
        return view('admin.coa.index', compact('data','office'));
    }

    public function getByAccountHead(Request $request)
    {
        $data = ChartOfAccount::where('account_head', $request->account_head)->where('office', $request->office)->get();
        if ($data->isEmpty()) {
            return response()->json(['status' => 303, 'message' => "No data found"]);
        } else {
            return response()->json(['status' => 300, 'data' => $data]);
        }
    }

    public function store(Request $request)
    {
        if(empty($request->account_head)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Account Head\" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->sub_account_head)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Sub Account Head \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->account_name)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Account Name \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }


        $data = new ChartOfAccount;
        $data->account_head = $request->account_head;
        $data->sub_account_head = $request->sub_account_head;
        $data->account_name = $request->account_name;
        $data->description = $request->description;
        $data->office = $request->office;
        $data->date = now();
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
        $info = ChartOfAccount::where($where)->get()->first();
        return response()->json($info);
    }

    public function update(Request $request)
    {
        if(empty($request->account_head)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Account Head\" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->sub_account_head)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Sub Account Head \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->account_name)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Account Name \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        
        $data = ChartOfAccount::find($request->codeid);
        $data->account_head = $request->account_head;
        $data->sub_account_head = $request->sub_account_head;
        $data->account_name = $request->account_name;
        $data->description = $request->description;
        $data->office = $request->office;
        $data->updated_by = Auth::user()->id;
        if ($data->save()) {
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Updated Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }

    public function delete($id)
    {

        if(ChartOfAccount::destroy($id)){
            return response()->json(['success'=>true,'message'=>'Data deleted successfully']);
        }else{
            return response()->json(['success'=>false,'message'=>'Delete Failed']);
        }
    }
}
