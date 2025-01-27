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
use App\Models\Expense;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $transactions = Expense::with('chartOfAccount')->where('status', 2);

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
        $accounts = ChartOfAccount::whereIn('account_head',[ 'Expenses','Asset'])->get();
        return view('admin.transactions.expense', compact('accounts'));
    }

    public function store(Request $request)
    {

        if (empty($request->date)) {
            return response()->json(['status' => 303, 'message' => 'Date Field Is Required..!']);
        }

        if (empty($request->transaction_type)) {
            return response()->json(['status' => 303, 'message' => 'Transaction Type Field Is Required..!']);
        }

        if (!in_array($request->transaction_type, ["Fahim", "Mehdi"]) && empty($request->chart_of_account_id)) {
            return response()->json(['status' => 303, 'message' => 'Chart of Account ID Field Is Required..!']);
        }

        if (empty($request->payment_type)) {
            return response()->json(['status' => 303, 'message' => 'Payment Type Field Is Required..!']);
        }

        if (empty($request->amount)) {
            return response()->json(['status' => 303, 'message' => 'Amount Field Is Required..!']);
        }

        $transaction = new Expense();
        $transaction->date = $request->input('date');
        if ($request->document) {
            
            $image = $request->document;
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/expense'), $imageName);
            $transaction->document = $imageName;
        }
        $transaction->amount = $request->input('amount');
        $transaction->riyal_amount = $request->input('riyal_amount');
        $transaction->tran_type = $request->input('transaction_type');
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
        $transaction = Expense::findOrFail($id);

        $responseData = [
            'id' => $transaction->id,
            'date' => $transaction->date,
            'chart_of_account_id' => $transaction->chart_of_account_id,
            'transaction_type' => $transaction->tran_type,
            'amount' => $transaction->amount,
            'riyal_amount' => $transaction->riyal_amount,
            'payment_type' => $transaction->account_id,
        ];
        return response()->json($responseData);
    }

    public function update(Request $request, $id)
    {

        if (empty($request->date)) {
            return response()->json(['status' => 303, 'message' => 'Date Field Is Required..!']);
        }

        if (!in_array($request->transaction_type, ["Fahim", "Mehdi"]) && empty($request->chart_of_account_id)) {
            return response()->json(['status' => 303, 'message' => 'Chart of Account ID Field Is Required..!']);
        }

        if (empty($request->amount)) {
            return response()->json(['status' => 303, 'message' => 'Amount Field Is Required..!']);
        }

        if (empty($request->transaction_type)) {
            return response()->json(['status' => 303, 'message' => 'Transaction Type Field Is Required..!']);
        }


        $transaction = Expense::find($id);

        if ($request->document) {
            $image_path = public_path('images/expense/' . $transaction->document);
            if (file_exists($image_path)) {
                unlink($image_path);
            }
            $image = $request->document;
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/expense'), $imageName);
            $transaction->document = $imageName;
        }

        $transaction->date = $request->input('date');
        $transaction->chart_of_account_id = $request->input('chart_of_account_id');
        $transaction->amount = $request->input('amount');
        $transaction->riyal_amount = $request->input('riyal_amount');
        $transaction->tran_type = $request->input('transaction_type');
        $transaction->account_id = $request->input('payment_type');
        $transaction->updated_by = Auth()->user()->id;
        $transaction->save();

        return response()->json(['status' => 200, 'message' => 'Updated Successfully']);

    }



    public function ksatransaction(Request $request)
    {
        $data = Expense::with('chartOfAccount')->whereIn('tran_type', ['KSA-Expense','KSA-Deposit'])->where('status', 2)->orderby('id', 'DESC')->get();
        $accounts = ChartOfAccount::where('account_head', 'Expenses')->get();
        $ksaTotal = Expense::where('tran_type', 'KSA-Deposit')->sum('riyal_amount');
        $ksaExp = Expense::where('tran_type', 'KSA-Expense')->sum('riyal_amount');
        return view('admin.transactions.ksa_transaction', compact('accounts','data','ksaTotal','ksaExp'));
    }

    public function ksatransactionstore(Request $request)
    {

        if (empty($request->date)) {
            return response()->json(['status' => 303, 'message' => 'Date Field Is Required..!']);
        }

        if (empty($request->transaction_type)) {
            return response()->json(['status' => 303, 'message' => 'Transaction Type Field Is Required..!']);
        }

        if (!in_array($request->transaction_type, ["Fahim", "Mehdi"]) && empty($request->chart_of_account_id)) {
            return response()->json(['status' => 303, 'message' => 'Chart of Account ID Field Is Required..!']);
        }

        if (empty($request->payment_type)) {
            return response()->json(['status' => 303, 'message' => 'Payment Type Field Is Required..!']);
        }

        if (empty($request->amount)) {
            return response()->json(['status' => 303, 'message' => 'Amount Field Is Required..!']);
        }

        $transaction = new Expense();
        if ($request->document) {
            $image = $request->document;
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/expense'), $imageName);
            $transaction->document = $imageName;
        }
        $transaction->date = $request->input('date');
        $transaction->amount = $request->input('amount');
        $transaction->riyal_amount = $request->input('riyal_amount');
        $transaction->tran_type = $request->input('transaction_type');
        $transaction->account_id = $request->input('payment_type');
        $transaction->chart_of_account_id = $request->input('chart_of_account_id');
        $transaction->created_by = Auth()->user()->id;

        $transaction->save();
        $transaction->tran_id = 'EX' . date('ymd') . str_pad($transaction->id, 4, '0', STR_PAD_LEFT);
        $transaction->save();

        return response()->json(['status' => 200, 'message' => 'Created Successfully']);

    }

    public function ksatransactionedit($id)
    {
        $transaction = Expense::findOrFail($id);

        $responseData = [
            'id' => $transaction->id,
            'date' => $transaction->date,
            'chart_of_account_id' => $transaction->chart_of_account_id,
            'transaction_type' => $transaction->tran_type,
            'amount' => $transaction->amount,
            'riyal_amount' => $transaction->riyal_amount,
            'payment_type' => $transaction->account_id,
        ];
        return response()->json($responseData);
    }

    public function ksatransactionupdate(Request $request)
    {

        if (empty($request->date)) {
            return response()->json(['status' => 303, 'message' => 'Date Field Is Required..!']);
        }

        if (!in_array($request->transaction_type, ["Fahim", "Mehdi"]) && empty($request->chart_of_account_id)) {
            return response()->json(['status' => 303, 'message' => 'Chart of Account ID Field Is Required..!']);
        }

        if (empty($request->amount)) {
            return response()->json(['status' => 303, 'message' => 'Amount Field Is Required..!']);
        }

        if (empty($request->transaction_type)) {
            return response()->json(['status' => 303, 'message' => 'Transaction Type Field Is Required..!']);
        }


        $transaction = Expense::find($request->codeid);

        if ($request->document) {
            $image_path = public_path('images/expense/' . $transaction->document);
            if (file_exists($image_path)) {
                unlink($image_path);
            }
            $image = $request->document;
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/expense'), $imageName);
            $transaction->document = $imageName;
        }
        
        $transaction->date = $request->input('date');
        $transaction->chart_of_account_id = $request->input('chart_of_account_id');
        $transaction->amount = $request->input('amount');
        $transaction->riyal_amount = $request->input('riyal_amount');
        $transaction->tran_type = $request->input('transaction_type');
        $transaction->account_id = $request->input('payment_type');
        $transaction->updated_by = Auth()->user()->id;
        $transaction->save();

        return response()->json(['status' => 200, 'message' => 'Updated Successfully']);

    }
    
}
