<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\BusinessPartner;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Client;
use App\Models\Country;
use App\Models\Okala;
use App\Models\OkalaSale;
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

            if ($request->client_id) {
                $client = Client::find($request->client_id);
                $client->total_rcv = $client->total_rcv + $request->amount;
                $client->due_amount = $client->due_amount - $request->amount;
                $client->save();
            }
            

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
            'account_id' => 'required',
            'paymentNote' => 'nullable',
        ]);

        $okala = Okala::where('id', $request->okalaId)->first();

        
            $transaction = new Transaction();

            // image
            if ($request->document != 'null') {
                $rand = mt_rand(100000, 999999);
                $ImageName = time(). $rand .'.'.$request->document->extension();
                $request->document->move(public_path('images/okala/document'), $ImageName);
                $transaction->document = $ImageName;
            }
            // end


            $transaction->okala_id = $okala->id;
            $transaction->vendor_id = $request->vendorId;
            $transaction->amount = $request->paymentAmount;
            $transaction->account_id = $request->account_id;
            $transaction->payment_type = "Payment";
            $transaction->note = $request->paymentNote;
            $transaction->tran_type = "Payment";
            $transaction->date = date('Y-m-d');
            $transaction->save();
            $transaction->tran_id = 'OK' . date('ymd') . str_pad($transaction->id, 4, '0', STR_PAD_LEFT);
            $transaction->save();

            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data store Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
    }

    public function vendorTran(Request $request)
    {
        $data = Transaction::where('okala_id',$request->okalaId)->where('vendor_id',$request->vendorId)->orderby('id', 'ASC')->get();

        $drAmount = Transaction::where('okala_id',$request->okalaId)->where('vendor_id',$request->vendorId)->where('tran_type', 'Payment')->sum('amount');

        $crAmount = Transaction::where('okala_id',$request->okalaId)->where('vendor_id',$request->vendorId)->where('tran_type', 'Purchase')->sum('amount');
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

                            if ($tran->tran_type == "Purchase") {
                                $prop.= '<td> </td>
                                        <td>
                                            '.$tran->amount.'
                                        </td>';
                            } else {
                                
                                $prop.= '<td>
                                            '.$tran->amount.'
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
            $transaction->payment_type = "Payment";
            $transaction->note = $request->paymentNote;
            $transaction->tran_type = "Payment";
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
            'account_id' => 'required',
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
            $transaction->amount = $request->amount;
            $transaction->riyalamount = $request->riyalamount;
            $transaction->account_id = $request->account_id;
            $transaction->payment_type = "Received";
            $transaction->note = $request->note;
            $transaction->tran_type = "Received";
            $transaction->date = date('Y-m-d');
            $transaction->save();
            $transaction->tran_id = 'OK' . date('ymd') . str_pad($transaction->id, 4, '0', STR_PAD_LEFT);
            $transaction->save();

            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data store Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
    }
}
