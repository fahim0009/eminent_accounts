<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChartOfAccount;
use App\Models\Employee;
use App\Models\Transaction;
use Yajra\DataTables\Facades\DataTables;

class AccountsController extends Controller
{
    public function dkAccount(Request $request)
    {
        if($request->ajax()){
            $assets = ChartOfAccount::whereIn('account_head',['Assets'])->get();
            $transactions = Transaction::with(['chartOfAccount', 'employee']) // add 'employee'
                ->where('office', 'dhaka')
                ->where('status', 1);

            if ($request->type) {
                $transactions->where('table_type', $request->input('type'));
            }

            if ($request->filled('start_date')) {
                $endDate = $request->filled('end_date') ? $request->input('end_date') : now()->endOfDay();
                $transactions->whereBetween('date', [
                    $request->input('start_date'),
                    $endDate
                ]);
            }

            if ($request->filled('account_head')) {
                $transactions->whereHas('chartOfAccount', function ($query) use ($request) {
                    $query->where('account_head', $request->input('account_head'));
                });
            }


            // monthly view
            if ($request->ajax() && $request->type === 'Monthly') {
                $transactions = Transaction::where('office', 'dhaka')
                    ->where('status', 1)
                    ->selectRaw("
                        DATE_FORMAT(date, '%Y-%m') as month,
                        SUM(CASE WHEN table_type = 'Expenses' THEN bdt_amount ELSE 0 END) as expense,
                        SUM(CASE WHEN table_type = 'Income' THEN bdt_amount ELSE 0 END) as income,
                        SUM(CASE WHEN table_type = 'Assets' THEN bdt_amount ELSE 0 END) as asset,
                        SUM(CASE WHEN table_type = 'Liabilities' THEN bdt_amount ELSE 0 END) as liability,
                        SUM(CASE WHEN table_type = 'Equity' THEN bdt_amount ELSE 0 END) as equity
                    ")
                    ->groupBy('month')
                    ->orderBy('month', 'DESC')
                    ->get();

                return DataTables::of($transactions)
                    ->editColumn('month', function($t) {
                        // Format month as "January 2025"
                        return \Carbon\Carbon::createFromFormat('Y-m', $t->month)->format('F Y');
                    })
                    ->make(true);
            }
            // monthly end 


            $transactions = $transactions->orderby('id', 'DESC')->get();

        return DataTables::of($transactions)
            ->addColumn('chart_of_account', function ($t) {
                $accountName = $t->chartOfAccount ? $t->chartOfAccount->account_name : $t->description;
                if ($t->employee && stripos($accountName, 'salary') !== false) {
                    // Only add employee if account name contains 'salary'
                    return $accountName . ' (' . $t->employee->name . ')';
                }
                return $accountName;
            })
            ->addColumn('account_name', function ($t) {
                return $t->account->name ?? '';
            })
            ->make(true);

        }
        $coa = ChartOfAccount::where('status', 1)->get();
        $employees = Employee::where('status', 1)->where('office', 'dhaka')->get();
        $accounts = ChartOfAccount::where('status', 1)
            ->select('account_head')
            ->distinct()
            ->get();


        return view('admin.transactions.dkaccounts', compact('coa','accounts','employees'));
    }


    public function ksaAccount(Request $request)
    {
        if($request->ajax()){
            $assets = ChartOfAccount::whereIn('account_head',['Assets'])->get();
            $transactions = Transaction::with('chartOfAccount')->where('office', 'ksa')->where('status', 1);

            if ($request->type) {
                $transactions->where('table_type', $request->input('type'));
            }

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

            $transactions = $transactions->orderby('id', 'DESC')->get();

            return DataTables::of($transactions)
                ->addColumn('chart_of_account', function ($transaction) {
                    return $transaction->chartOfAccount ? $transaction->chartOfAccount->account_name : $transaction->description;
                })
                ->addColumn('account_name', function ($transaction) {
                    return $transaction->account ? $transaction->account->name : "";
                })
                ->make(true);
        }
        $coa = ChartOfAccount::where('status', 1)->get();
        
        $employees = Employee::where('status', 1)->where('office', 'ksa')->get();
        $accounts = ChartOfAccount::where('sub_account_head', 'Account Payable')->get(['account_name', 'id']);
        return view('admin.transactions.ksaaccounts', compact('coa','accounts','employees'));
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

        if (empty($request->amount) && empty($request->riyal_amount)) {
            return response()->json(['status' => 303, 'message' => 'Amount Field Is Required..!']);
        }

        $transaction = new Transaction();
        $transaction->table_type = $request->account_head;
        $transaction->office = $request->office;
        $transaction->note = $request->note;
        $transaction->chart_of_account_val = $request->chart_of_account_val;
        $transaction->employee_id = $request->employee_id;
        $transaction->date = $request->input('date');
        if ($request->document) {
            
            $image = $request->document;
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/asset'), $imageName);
            $transaction->document = $imageName;
        }
        
        $transaction->bdt_amount = $request->input('amount') ?? "0.00";
        $transaction->foreign_amount = $request->input('riyal_amount') ?? "0.00";
        $transaction->foreign_amount_type = 'riyal';
        $transaction->tran_type = $request->input('transaction_type');
        $transaction->account_id = $request->input('payment_type');
        $transaction->chart_of_account_id = $request->input('chart_of_account_id');

        $transaction->created_by = Auth()->user()->id;
        $transaction->save();
        $transaction->tran_id = 'TRN' . date('ymd') . str_pad($transaction->id, 4, '0', STR_PAD_LEFT);
        $transaction->save();

        return response()->json(['status' => 200, 'message' => 'Created Successfully','document' => $request->document]);

    }

    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);
        $coa = ChartOfAccount::where('account_head', $transaction->chartOfAccount->account_head)->where('office', $transaction->office)->get();
        $responseData = [
            'id' => $transaction->id,
            'date' => $transaction->date,
            'chart_of_account_id' => $transaction->chart_of_account_id,
            'account_head' => $transaction->chartOfAccount->account_head,
            'office' => $transaction->office,
            'transaction_type' => $transaction->tran_type,
            'amount' => $transaction->bdt_amount,
            'riyal_amount' => $transaction->foreign_amount,
            'payment_type' => $transaction->account_id,
            'chart_of_account_val' => $transaction->chart_of_account_val,
            'employee_id' => $transaction->employee_id,
            'coa' => $coa,
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

        if (empty($request->amount) && empty($request->riyal_amount)) {
            return response()->json(['status' => 303, 'message' => 'Amount Field Is Required..!']);
        }

        if (empty($request->office)) {
            return response()->json(['status' => 303, 'message' => 'Office Field Is Required..!']);
        }
        if (empty($request->payment_type)) {
            return response()->json(['status' => 303, 'message' => 'Payment Type Field Is Required..!']);
        }

        $transaction = Transaction::find($id);

        $transaction->chart_of_account_val = $request->chart_of_account_val;
        $transaction->employee_id = $request->employee_id;

        if ($request->document) {
            $image_path = public_path('images/asset/' . $transaction->document);
            if (file_exists($image_path)) {
                unlink($image_path);
            }
            $image = $request->document;
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/asset'), $imageName);
            $transaction->document = $imageName;
        }

        $transaction->date = $request->input('date');
        $transaction->table_type = $request->account_head;
        $transaction->bdt_amount = $request->input('amount') ?? "0.00";
        $transaction->foreign_amount = $request->input('riyal_amount') ?? "0.00";
        $transaction->foreign_amount_type = 'riyal';
        $transaction->office = $request->input('office');
        $transaction->tran_type = $request->input('transaction_type');
        $transaction->account_id = $request->input('payment_type');
        $transaction->chart_of_account_id = $request->input('chart_of_account_id');


        $transaction->updated_by = Auth()->user()->id;
        $transaction->save();

        return response()->json(['status' => 200, 'message' => 'Updated Successfully']);

    }
}
