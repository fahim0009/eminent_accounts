<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\ChartOfAccount;

class EquityController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $equity = ChartOfAccount::whereIn('account_head',[ 'Equity'])->get();
            $transactions = Transaction::with('chartOfAccount')->where('table_type', 'Equity')->where('status', 1);

        if ($request->filled('start_date')) {
                $endDate = $request->filled('end_date') ? $request->input('end_date') : now()->endOfDay();
                $transactions->whereBetween('date', [
                    $request->input('start_date'),
                    $endDate
                ]);
            }

            if ($request->filled('account_name')) {
                $transactions->whereHas('chartOfAccount', function ($query) use ($request) {
                    $query->where('account_name', $request->input('account_name'));
                });
            }

            $transactions = $transactions->latest()->get();

            return DataTables::of($transactions)
                ->addColumn('chart_of_account', function ($transaction) {
                    return $transaction->chartOfAccount ? $transaction->chartOfAccount->account_name : $transaction->description;
                })
                ->addColumn('account_name', function ($transaction) {
                    return $transaction->account ? $transaction->account->name : "";
                })
                ->make(true);
        }
        $coa = ChartOfAccount::whereIn('account_head',['Equity'])->get();
        
        $accounts = ChartOfAccount::where('sub_account_head', 'Account Payable')->get(['account_name', 'id']);
        return view('admin.transactions.equity', compact('coa','accounts'));
    }

    public function store(Request $request)
    {

        if (empty($request->date)) {
            return response()->json(['status' => 303, 'message' => 'Date Field Is Required..!']);
        }

        if (empty($request->office)) {
            return response()->json(['status' => 303, 'message' => 'Office Field Is Required..!']);
        }

        if (empty($request->transaction_type)) {
            return response()->json(['status' => 303, 'message' => 'Transaction Type Field Is Required..!']);
        }


        if (empty($request->chart_of_account_id)) {
            return response()->json(['status' => 303, 'message' => 'Chart of Account ID Field Is Required..!']);
        }

        if (empty($request->payment_type)) {
            return response()->json(['status' => 303, 'message' => 'Payment Type Field Is Required..!']);
        }

        if (empty($request->amount)) {
            return response()->json(['status' => 303, 'message' => 'Amount Field Is Required..!']);
        }

        $transaction = new Transaction();
        $transaction->table_type = 'Equity';
        $transaction->office = $request->office;
        $transaction->transaction_type = $request->transaction_type;
        $transaction->date = $request->input('date');
        if ($request->document) {
            
            $image = $request->document;
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/equity'), $imageName);
            $transaction->document = $imageName;
        }
        
        $transaction->bdt_amount = $request->input('amount');
        $transaction->foreign_amount = $request->input('riyal_amount') ?? "0.00";
        $transaction->foreign_amount_type = 'riyal';
        $transaction->account_id = $request->input('payment_type');
        $transaction->chart_of_account_id = $request->input('chart_of_account_id');

        $transaction->created_by = Auth()->user()->id;
        $transaction->save();
        $transaction->tran_id = 'EX' . date('ymd') . str_pad($transaction->id, 4, '0', STR_PAD_LEFT);
        $transaction->save();

        return response()->json(['status' => 200, 'message' => 'Created Successfully','document' => $request->document]);

    }

    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);

        $responseData = [
            'id' => $transaction->id,
            'date' => $transaction->date,
            'chart_of_account_id' => $transaction->chart_of_account_id,
            'office' => $transaction->office,
            'amount' => $transaction->bdt_amount,
            'riyal_amount' => $transaction->foreign_amount,
            'payment_type' => $transaction->account_id,
        ];
        return response()->json($responseData);
    }

    public function update(Request $request, $id)
    {

        if (empty($request->date)) {
            return response()->json(['status' => 303, 'message' => 'Date Field Is Required..!']);
        }

        if (empty($request->chart_of_account_id)) {
            return response()->json(['status' => 303, 'message' => 'Chart of Account ID Field Is Required..!']);
        }
        if (empty($request->transaction_type)) {
            return response()->json(['status' => 303, 'message' => 'Transaction Type Field Is Required..!']);
        }

        if (empty($request->amount)) {
            return response()->json(['status' => 303, 'message' => 'Amount Field Is Required..!']);
        }

        if (empty($request->office)) {
            return response()->json(['status' => 303, 'message' => 'Office Field Is Required..!']);
        }


        $transaction = Transaction::find($id);

        if ($request->document) {
            $image_path = public_path('images/equity/' . $transaction->document);
            if (file_exists($image_path)) {
                unlink($image_path);
            }
            $image = $request->document;
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/equity'), $imageName);
            $transaction->document = $imageName;
        }

        $transaction->date = $request->input('date');
        $transaction->bdt_amount = $request->input('amount');
        $transaction->foreign_amount = $request->input('riyal_amount') ?? "0.00";
        $transaction->foreign_amount_type = 'riyal';
        $transaction->office = $request->input('office');
        $transaction->transaction_type = $request->transaction_type;
        $transaction->account_id = $request->input('payment_type');
        $transaction->chart_of_account_id = $request->input('chart_of_account_id');


        $transaction->updated_by = Auth()->user()->id;
        $transaction->save();

        return response()->json(['status' => 200, 'message' => 'Updated Successfully']);

    }
}
