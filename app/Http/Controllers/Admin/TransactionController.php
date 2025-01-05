<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\BusinessPartner;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Client;
use App\Models\Country;
use App\Models\OkalaPurchase;
use App\Models\OkalaSale;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function moneyreceived(Request $request)
    {
        if(empty($request->date)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Date \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(($request->tran_type == "package_received") && empty($request->account_id)){
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
        $data->bdt_amount = $request->amount;
        $data->note = $request->note;
        $data->client_id = $request->client_id;
        $data->tran_type = $request->tran_type;
        $data->ref = $request->ref;
        $data->created_by = Auth::user()->id;
        if ($data->save()) {

            $data->tran_id = 'RCVD' . date('ymd') . str_pad($data->id, 4, '0', STR_PAD_LEFT);
            $data->save();            
            if(isset($request->account_id)){
            $account = Account::find($request->account_id);
            $account->balance = $account->balance + $request->amount;
            $account->save();
            }

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


            $account = Account::find($data->account_id);
            $account->balance = $account->balance - $data->amount;
            $account->save();

        $data->date = $request->date;
        $data->account_id = $request->account_id;
        $data->bdt_amount = $request->amount;
        $data->note = $request->note;
        $data->ref = $request->ref;
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


    public function billCreate(Request $request)
    {
      
        if(empty($request->amount)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"amount \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        

        $data = new Transaction;
        $data->date = $request->date;
        $data->user_id = $request->user_id;
        $data->bdt_amount = $request->amount;
        $data->note = $request->note;
        $data->client_id = $request->client_id;
        $data->tran_type = $request->tran_type;
        $data->ref = $request->ref;
        $data->created_by = Auth::user()->id;
        if ($data->save()) {

            $data->tran_id = 'BILL' . date('ymd') . str_pad($data->id, 4, '0', STR_PAD_LEFT);
            $data->save();
     
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Create Successfully.</b></div>";
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
        $data->ref = $request->ref;
        $data->created_by = Auth::user()->id;
        if ($data->save()) {

            $data->tran_id = 'PAY' . date('ymd') . str_pad($data->id, 4, '0', STR_PAD_LEFT);
            $data->save();

            $client = Client::find($request->client_id);
            $client->b2b_payment = $client->b2b_payment + $request->amount;
            $client->save();

            $account = Account::find($request->account_id);
            $account->balance = $account->balance - $request->amount;
            $account->save();

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

            $account = Account::find($data->account_id);
            $account->balance = $account->balance + $data->amount;
            $account->save();

        $data->date = $request->date;
        $data->account_id = $request->account_id;
        $data->amount = $request->amount;
        $data->note = $request->note;
        $data->ref = $request->ref;
        $data->updated_by = Auth::user()->id;
        if ($data->save()) {

            $upaccount = Account::find($request->account_id);
            $upaccount->balance = $account->balance - $request->amount;
            $upaccount->save();

            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Updated Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }

    public function vendorPay(Request $request)
    {
        $request->validate([
            'vendorId' => 'required',
            'paymentAmount' => 'required',
            'paymentNote' => 'nullable',
        ]);

        $okala = OkalaPurchase::where('id', $request->okalaId)->first();

        
            $transaction = new Transaction();

            // image
            if ($request->document != 'null') {
                $rand = mt_rand(100000, 999999);
                $ImageName = time(). $rand .'.'.$request->document->extension();
                $request->document->move(public_path('images/okala/document'), $ImageName);
                $transaction->document = $ImageName;
            }
            // end


            $transaction->okala_purchase_id = $okala->id;
            $transaction->user_id = $request->vendorId;
            $transaction->bdt_amount = $request->paymentAmount;
            $transaction->foreign_amount = $request->paymentRiyalAmount;
            !empty($request->account_id) && $transaction->account_id = $request->account_id;
            $transaction->payment_type = $request->paymentType;
            $transaction->note = $request->paymentNote;
            $transaction->tran_type = "okala_payment";
            $transaction->ref = $request->ref;
            $transaction->date = $request->paymentDate;
            $transaction->save();
            $transaction->tran_id = 'OKPAY' . date('ymd') . str_pad($transaction->id, 4, '0', STR_PAD_LEFT);
            $transaction->save();

            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data store Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
    }

    public function purchaseTran(Request $request)
    {
        $data = Transaction::where('okala_purchase_id',$request->okalaId)->where('user_id',$request->vendorId)->orderby('id', 'ASC')->get();
        $drAmount = Transaction::where('okala_purchase_id',$request->okalaId)->where('user_id',$request->vendorId)->where('tran_type', 'okala_received')->sum('bdt_amount');

        $crAmount = Transaction::where('okala_purchase_id',$request->okalaId)->where('user_id',$request->vendorId)->where('tran_type', 'okala_purchase')->sum('bdt_amount');
        $balance =  $crAmount - $drAmount;
        $prop = '';
        
            foreach ($data as $tran){

                if (isset($tran->account_id)) {
                    $account = Account::where('id', $tran->account_id)->first();
                    $accountName = $account->name;
                }else{
                    $accountName = ' ';
                }
                
                // <!-- Single Property Start -->
                $prop.= '<tr>
                            <td>
                                '.$tran->date.'
                            </td>
                            <td>
                                '.$tran->payment_type.'
                            </td>
                            <td>
                                '.$accountName.'
                            </td>';

                            if ($tran->tran_type == "okala_purchase") {
                                $prop.= '<td> </td>
                                        <td>
                                            '.$tran->bdt_amount.'
                                        </td>';
                            } else {
                                
                                $prop.= '<td>
                                            '.$tran->bdt_amount.'
                                        </td>
                                        <td> </td>'; 
                            }
                            
                        $prop.= '</tr>';
            }

        return response()->json(['status'=> 300,'data'=>$prop, 'balance'=>$balance]);
    }

    public function vendorTran(Request $request)
    {
        $data = Transaction::where('okala_sale_id',$request->okalaId)->where('user_id',$request->vendorId)->orderby('id', 'ASC')->get();
        $drAmount = Transaction::where('okala_sale_id',$request->okalaId)->where('user_id',$request->vendorId)->where('tran_type', 'okala_received')->sum('bdt_amount');

        $crAmount = Transaction::where('okala_sale_id',$request->okalaId)->where('user_id',$request->vendorId)->where('tran_type', 'okala_purchase')->sum('bdt_amount');
        $balance =  $crAmount - $drAmount;
        $prop = '';
        
            foreach ($data as $tran){

                if (isset($tran->account_id)) {
                    $account = Account::where('id', $tran->account_id)->first();
                    $accountName = $account->name;
                }else{
                    $accountName = ' ';
                }
                
                // <!-- Single Property Start -->
                $prop.= '<tr>
                            <td>
                                '.$tran->date.'
                            </td>
                            <td>
                                '.$tran->payment_type.'
                            </td>
                            <td>
                                '.$accountName.'
                            </td>';

                            if ($tran->tran_type == "okala_sales") {
                                $prop.= '<td> </td>
                                        <td>
                                            '.$tran->bdt_amount.'
                                        </td>';
                            } else {
                                
                                $prop.= '<td>
                                            '.$tran->bdt_amount.'
                                        </td>
                                        <td> </td>'; 
                            }
                            
                        $prop.= '</tr>';
            }

        return response()->json(['status'=> 300,'data'=>$prop, 'balance'=>$balance]);
    }


    public function vendorOkalaSalesPay(Request $request)
    {
        $request->validate([
            'vendorId' => 'required',
            'paymentAmount' => 'required',
            'riyalamount' => 'required',
            'account_id' => 'required',
            'paymentNote' => 'nullable',
        ]);

        $okala = OkalaSale::where('id', $request->okalaId)->first();

        
            $transaction = new Transaction();
            // image
            if ($request->document != 'null') {
                $rand = mt_rand(100000, 999999);
                $ImageName = time(). $rand .'.'.$request->document->extension();
                $request->document->move(public_path('images/okala/document'), $ImageName);
                $transaction->document = $ImageName;
            }
            // end
            $transaction->okala_sale_id = $okala->id;
            $transaction->vendor_id = $request->vendorId;
            $transaction->amount = $request->paymentAmount;
            $transaction->riyalamount = $request->riyalamount;
            $transaction->account_id = $request->account_id;
            $transaction->payment_type = $request->paymentType;
            $transaction->note = $request->paymentNote;
            $transaction->tran_type = "okala_payment";
            $transaction->ref = $request->ref;
            $transaction->date = date('Y-m-d');
            $transaction->save();
            $transaction->tran_id = 'OK' . date('ymd') . str_pad($transaction->id, 4, '0', STR_PAD_LEFT);
            $transaction->save();

            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data store Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
    }

    public function okalaSalesReceive(Request $request)
    {
        $request->validate([
            'agentId' => 'required',
            'amount' => 'required',
            'riyalamount' => 'required',
            // 'account_id' => 'required',
            'note' => 'nullable',
        ]);

        $okala = OkalaSale::where('id', $request->okalaId)->first();

        
            $transaction = new Transaction();
            // image
            if ($request->document != 'null') {
                $rand = mt_rand(100000, 999999);
                $ImageName = time(). $rand .'.'.$request->document->extension();
                $request->document->move(public_path('images/okala/document'), $ImageName);
                $transaction->document = $ImageName;
            }
            // end
            $transaction->okala_sale_id = $okala->id;
            $transaction->user_id = $request->agentId;
            $transaction->bdt_amount = $request->amount;
            $transaction->foreign_amount = $request->riyalamount;
            $transaction->foreign_amount_type = 'riyal';
            $transaction->account_id = $request->account_id;
            $transaction->payment_type = $request->paymentType;
            $transaction->note = $request->note;
            $transaction->tran_type = "okala_received";
            $transaction->ref = $request->ref;
            $transaction->date = $request->paymentDate;
            $transaction->save();
            $transaction->tran_id = 'OKR' . date('ymd') . str_pad($transaction->id, 4, '0', STR_PAD_LEFT);
            $transaction->save();

            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data store Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
    }
}
