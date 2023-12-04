<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\BusinessPartner;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Client;
use App\Models\Country;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function moneyreceived(Request $request)
    {
        if(empty($request->account_id)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Transaction method \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(empty($request->amount)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"amount \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        

        $data = new Transaction;
        $data->date = $request->date;
        $data->account_id = $request->account_id;
        $data->user_id = $request->user_id;
        $data->amount = $request->amount;
        $data->note = $request->note;
        $data->client_id = $request->client_id;
        $data->tran_type = $request->tran_type;
        $data->created_by = Auth::user()->id;
        if ($data->save()) {

            $client = Client::find($request->client_id);
            $client->total_rcv = $client->total_rcv + $request->amount;
            $client->due_amount = $client->due_amount - $request->amount;
            $client->save();

            $account = Account::find($request->account_id);
            $account->balance = $account->balance + $request->amount;
            $account->save();

            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Create Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }

    public function moneyReceivedEdit($id)
    {
        $where = [
            'id'=>$id
        ];
        $info = Transaction::where($where)->get()->first();
        return response()->json($info);
    }

    public function moneyReceivedUpdate(Request $request)
    {
        if(empty($request->account_id)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Transaction method \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(empty($request->amount)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"amount \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        $data = Transaction::find($request->tran_id);

            $client = Client::find($request->client_id);
            $client->total_rcv = $client->total_rcv + $request->amount - $data->amount;
            $client->due_amount = $client->due_amount - $request->amount + $data->amount;
            $client->save();

            $account = Account::find($data->account_id);
            $account->balance = $account->balance - $data->amount;
            $account->save();

        $data->date = $request->date;
        $data->account_id = $request->account_id;
        $data->amount = $request->amount;
        $data->note = $request->note;
        $data->updated_by = Auth::user()->id;
        if ($data->save()) {

            $upaccount = Account::find($request->account_id);
            $upaccount->balance = $upaccount->balance + $request->amount;
            $upaccount->save();


            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Updated Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }



    public function moneyPayment(Request $request)
    {
        if(empty($request->account_id)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Transaction method \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(empty($request->amount)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"amount \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        

        $data = new Transaction;
        $data->date = $request->date;
        $data->account_id = $request->account_id;
        $data->user_id = $request->user_id;
        $data->amount = $request->amount;
        $data->note = $request->note;
        $data->client_id = $request->client_id;
        $data->tran_type = $request->tran_type;
        $data->business_partner_id = $request->business_partner_id;
        $data->created_by = Auth::user()->id;
        if ($data->save()) {

            $client = Client::find($request->client_id);
            $client->b2b_payment = $client->b2b_payment + $request->amount;
            $client->save();

            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Create Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }

    public function moneyPaymentEdit($id)
    {
        $where = [
            'id'=>$id
        ];
        $info = Transaction::where($where)->get()->first();
        return response()->json($info);
    }

    public function moneyPaymentUpdate(Request $request)
    {
        if(empty($request->account_id)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Transaction method \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(empty($request->amount)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"amount \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        $data = Transaction::find($request->tran_id);

            $client = Client::find($request->client_id);
            $client->total_rcv = $client->total_rcv + $request->amount - $data->amount;
            $client->due_amount = $client->due_amount - $request->amount + $data->amount;
            $client->save();

        $data->date = $request->date;
        $data->account_id = $request->account_id;
        $data->amount = $request->amount;
        $data->note = $request->note;
        $data->updated_by = Auth::user()->id;
        if ($data->save()) {
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Updated Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }
}
