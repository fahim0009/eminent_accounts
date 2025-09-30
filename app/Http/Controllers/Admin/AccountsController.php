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
                    ->where('status', 1);

                if ($request->filled('start_date')) {
                        $endDate = $request->filled('end_date') ? $request->input('end_date') : now()->endOfDay();
                        $transactions->whereBetween('date', [$request->start_date, $endDate]);
                    }

                   $transactions = $transactions->selectRaw("
                        DATE_FORMAT(date, '%Y-%m') as month,
                        SUM(CASE WHEN table_type = 'Income' THEN bdt_amount ELSE 0 END) as monthly_income,
                        SUM(CASE WHEN table_type = 'Expenses' THEN bdt_amount ELSE 0 END) as monthly_expense,
                        SUM(CASE WHEN table_type = 'Liabilities' AND tran_type = 'received' THEN bdt_amount ELSE 0 END) as monthly_liabilities_received,
                        SUM(CASE WHEN table_type = 'Liabilities' AND tran_type = 'payment' THEN bdt_amount ELSE 0 END) as monthly_liabilities_payment,
                        SUM(CASE WHEN table_type = 'Assets' AND tran_type = 'purchase' THEN bdt_amount ELSE 0 END) as monthly_assets_purchase,
                        SUM(CASE WHEN table_type = 'Assets' AND tran_type = 'sales' THEN bdt_amount ELSE 0 END) as monthly_assets_sales,
                        SUM(CASE WHEN table_type = 'Equity' AND tran_type = 'capital' THEN bdt_amount ELSE 0 END) as monthly_equity_add,
                        SUM(CASE WHEN table_type = 'Equity' AND tran_type = 'withdrawal' THEN bdt_amount ELSE 0 END) as monthly_equity_deduct
                    ")
                    ->groupBy('month')
                    ->orderBy('month', 'DESC')
                    ->get();

                return DataTables::of($transactions)

                        ->editColumn('month', function ($t) {
                            return [
                                'display'   => \Carbon\Carbon::createFromFormat('Y-m', $t->month)->format('F Y'),
                                'timestamp' => $t->month, // keep raw YYYY-MM for sorting
                            ];
                        })

                        ->addColumn('monthly_assets', function ($t) {
                            return $t->monthly_assets_purchase - $t->monthly_assets_sales;
                        })
                        ->addColumn('monthly_liability', function ($t) {
                            return $t->monthly_liabilities_received - $t->monthly_liabilities_payment;
                        })
                        ->addColumn('monthly_equity', function ($t) {
                            return $t->monthly_equity_add - $t->monthly_equity_deduct;
                        })
                        ->addColumn('monthly_balance', function ($t) {
                            $assets = $t->monthly_assets_purchase - $t->monthly_assets_sales;
                            $loanBalance = $t->monthly_liabilities_received - $t->monthly_liabilities_payment;
                            $equity = $t->monthly_equity_add - $t->monthly_equity_deduct;
                            return ($t->monthly_income - $t->monthly_expense) + $loanBalance - $assets + $equity;
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

        // ---- Lifetime Balance Calculation ----
            $summary = Transaction::where('office', 'dhaka')
                ->where('status', 1)
                ->selectRaw("
                    SUM(CASE WHEN table_type = 'Income' THEN bdt_amount ELSE 0 END) as total_income,
                    SUM(CASE WHEN table_type = 'Expenses' THEN bdt_amount ELSE 0 END) as total_expense,
                    SUM(CASE WHEN table_type = 'Liabilities' AND tran_type = 'received' THEN bdt_amount ELSE 0 END) as liabilities_received,
                    SUM(CASE WHEN table_type = 'Liabilities' AND tran_type = 'payment' THEN bdt_amount ELSE 0 END) as liabilities_payment,
                    SUM(CASE WHEN table_type = 'Assets' AND tran_type = 'purchase' THEN bdt_amount ELSE 0 END) as assets_purchase,
                    SUM(CASE WHEN table_type = 'Assets' AND tran_type = 'sales' THEN bdt_amount ELSE 0 END) as assets_sales,
                    SUM(CASE WHEN table_type = 'Equity' AND tran_type = 'capital' THEN bdt_amount ELSE 0 END) as equity_add,
                    SUM(CASE WHEN table_type = 'Equity' AND tran_type = 'withdrawal' THEN bdt_amount ELSE 0 END) as equity_deduct
                ")
                ->first();

            $assets =  $summary->assets_purchase - $summary->assets_sales;

            $assetsExp =  $summary->assets_sales - $summary->assets_purchase;

            $equity = $summary->equity_add - $summary->equity_deduct;

            $balance = ($summary->total_income - $summary->total_expense)
                    + ($summary->liabilities_received - $summary->liabilities_payment)
                    + $assetsExp + $equity;

            $loanBalance = $summary->liabilities_received - $summary->liabilities_payment;


        $coa = ChartOfAccount::where('status', 1)->get();
        $employees = Employee::where('status', 1)->where('office', 'dhaka')->get();
        $accounts = ChartOfAccount::where('status', 1)
            ->select('account_head')
            ->distinct()
            ->get();


        return view('admin.transactions.dkaccounts', compact('coa','accounts','employees','loanBalance','balance','equity','assets'));
    }


    public function ksaAccount(Request $request)
    {
        if($request->ajax()){
            $assets = ChartOfAccount::whereIn('account_head',['Assets'])->get();
            $transactions = Transaction::with(['chartOfAccount', 'employee']) // add 'employee'
                ->where('office', 'ksa')
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

                $transactions = Transaction::where('office', 'ksa')
                    ->where('status', 1);

                if ($request->filled('start_date')) {
                        $endDate = $request->filled('end_date') ? $request->input('end_date') : now()->endOfDay();
                        $transactions->whereBetween('date', [$request->start_date, $endDate]);
                    }

                   $transactions = $transactions->selectRaw("
                        DATE_FORMAT(date, '%Y-%m') as month,
                        SUM(CASE WHEN table_type = 'Income' THEN foreign_amount ELSE 0 END) as monthly_income,
                        SUM(CASE WHEN table_type = 'Expenses' THEN foreign_amount ELSE 0 END) as monthly_expense,
                        SUM(CASE WHEN table_type = 'Liabilities' AND tran_type = 'received' THEN foreign_amount ELSE 0 END) as monthly_liabilities_received,
                        SUM(CASE WHEN table_type = 'Liabilities' AND tran_type = 'payment' THEN foreign_amount ELSE 0 END) as monthly_liabilities_payment,
                        SUM(CASE WHEN table_type = 'Assets' AND tran_type = 'purchase' THEN foreign_amount ELSE 0 END) as monthly_assets_purchase,
                        SUM(CASE WHEN table_type = 'Assets' AND tran_type = 'sales' THEN foreign_amount ELSE 0 END) as monthly_assets_sales,
                        SUM(CASE WHEN table_type = 'Equity' AND tran_type = 'capital' THEN foreign_amount ELSE 0 END) as monthly_equity_add,
                        SUM(CASE WHEN table_type = 'Equity' AND tran_type = 'withdrawal' THEN foreign_amount ELSE 0 END) as monthly_equity_deduct
                    ")
                    ->groupBy('month')
                    ->orderBy('month', 'DESC')
                    ->get();

                return DataTables::of($transactions)

                        ->editColumn('month', function ($t) {
                            return [
                                'display'   => \Carbon\Carbon::createFromFormat('Y-m', $t->month)->format('F Y'),
                                'timestamp' => $t->month, // keep raw YYYY-MM for sorting
                            ];
                        })

                        ->addColumn('monthly_assets', function ($t) {
                            return $t->monthly_assets_purchase - $t->monthly_assets_sales;
                        })
                        ->addColumn('monthly_liability', function ($t) {
                            return $t->monthly_liabilities_received - $t->monthly_liabilities_payment;
                        })
                        ->addColumn('monthly_equity', function ($t) {
                            return $t->monthly_equity_add - $t->monthly_equity_deduct;
                        })
                        ->addColumn('monthly_balance', function ($t) {
                            $assets = $t->monthly_assets_purchase - $t->monthly_assets_sales;
                            $loanBalance = $t->monthly_liabilities_received - $t->monthly_liabilities_payment;
                            $equity = $t->monthly_equity_add - $t->monthly_equity_deduct;
                            return ($t->monthly_income - $t->monthly_expense) + $loanBalance - $assets + $equity;
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

        // ---- Lifetime Balance Calculation ----
            $summary = Transaction::where('office', 'ksa')
                ->where('status', 1)
                ->selectRaw("
                    SUM(CASE WHEN table_type = 'Income' THEN foreign_amount ELSE 0 END) as total_income,
                    SUM(CASE WHEN table_type = 'Expenses' THEN foreign_amount ELSE 0 END) as total_expense,
                    SUM(CASE WHEN table_type = 'Liabilities' AND tran_type = 'received' THEN foreign_amount ELSE 0 END) as liabilities_received,
                    SUM(CASE WHEN table_type = 'Liabilities' AND tran_type = 'payment' THEN foreign_amount ELSE 0 END) as liabilities_payment,
                    SUM(CASE WHEN table_type = 'Assets' AND tran_type = 'purchase' THEN foreign_amount ELSE 0 END) as assets_purchase,
                    SUM(CASE WHEN table_type = 'Assets' AND tran_type = 'sales' THEN foreign_amount ELSE 0 END) as assets_sales,
                    SUM(CASE WHEN table_type = 'Equity' AND tran_type = 'capital' THEN foreign_amount ELSE 0 END) as equity_add,
                    SUM(CASE WHEN table_type = 'Equity' AND tran_type = 'withdrawal' THEN foreign_amount ELSE 0 END) as equity_deduct
                ")
                ->first();

            $assets =  $summary->assets_purchase - $summary->assets_sales;

            $assetsExp =  $summary->assets_sales - $summary->assets_purchase;

            $equity = $summary->equity_add - $summary->equity_deduct;

            $balance = ($summary->total_income - $summary->total_expense)
                    + ($summary->liabilities_received - $summary->liabilities_payment)
                    + $assetsExp + $equity;

            $loanBalance = $summary->liabilities_received - $summary->liabilities_payment;


        $coa = ChartOfAccount::where('status', 1)->get();
        $employees = Employee::where('status', 1)->where('office', 'dhaka')->get();
        $accounts = ChartOfAccount::where('status', 1)
            ->select('account_head')
            ->distinct()
            ->get();


        return view('admin.transactions.ksaaccounts', compact('coa','accounts','employees','loanBalance','balance','equity','assets'));
    }
    

    public function dkStore(Request $request)
    {

        if (empty($request->date)) {
            return response()->json(['status' => 303, 'message' => 'Date Field Is Required..!']);
        }

        if (empty($request->office)) {
            return response()->json(['status' => 303, 'message' => 'Office Field Is Required..!']);
        }

        if (empty($request->transaction_type)) {
            return response()->json(['status' => 303, 'message' => 'Account Head Is Field Is Required..!']);
        }

        if (empty($request->chart_of_account_id)) {
            return response()->json(['status' => 303, 'message' => 'Chart of Account ID Field Is Required..!']);
        }

        if (empty($request->payment_type)) {
            return response()->json(['status' => 303, 'message' => 'Payment Type Field Is Required..!']);
        }

        if (empty($request->bdt_amount)) {
            return response()->json(['status' => 303, 'message' => 'BDT Amount Field Is Required..!']);
        }

        $transaction = new Transaction();
        $transaction->table_type = $request->account_head;
        $transaction->office = "dhaka";
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
        
        $transaction->bdt_amount = $request->input('bdt_amount') ?? "0.00";
        $transaction->tran_type = $request->input('transaction_type');
        $transaction->account_id = $request->input('payment_type');
        $transaction->chart_of_account_id = $request->input('chart_of_account_id');

        $transaction->created_by = Auth()->user()->id;
        $transaction->save();
        $transaction->tran_id = 'TRN' . date('ymd') . str_pad($transaction->id, 4, '0', STR_PAD_LEFT);
        $transaction->save();

        return response()->json(['status' => 300, 'message' => 'Created Successfully','document' => $request->document]);

    }

        public function ksaStore(Request $request)
    {

        if (empty($request->date)) {
            return response()->json(['status' => 303, 'message' => 'Date Field Is Required..!']);
        }

        if (empty($request->office)) {
            return response()->json(['status' => 303, 'message' => 'Office Field Is Required..!']);
        }

        if (empty($request->transaction_type)) {
            return response()->json(['status' => 303, 'message' => 'Account Head Is Field Is Required..!']);
        }

        if (empty($request->chart_of_account_id)) {
            return response()->json(['status' => 303, 'message' => 'Chart of Account ID Field Is Required..!']);
        }

        if (empty($request->payment_type)) {
            return response()->json(['status' => 303, 'message' => 'Payment Type Field Is Required..!']);
        }

        if (empty($request->riyal_amount)) {
            return response()->json(['status' => 303, 'message' => 'Riyal Amount Field Is Required..!']);
        }

        $transaction = new Transaction();
        $transaction->table_type = $request->account_head;
        $transaction->office = "ksa";
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
        
        $transaction->foreign_amount = $request->input('riyal_amount') ?? "0.00";
        $transaction->foreign_amount_type = 'riyal';
        $transaction->tran_type = $request->input('transaction_type');
        $transaction->account_id = $request->input('payment_type');
        $transaction->chart_of_account_id = $request->input('chart_of_account_id');

        $transaction->created_by = Auth()->user()->id;
        $transaction->save();
        $transaction->tran_id = 'TRN' . date('ymd') . str_pad($transaction->id, 4, '0', STR_PAD_LEFT);
        $transaction->save();

        return response()->json(['status' => 300, 'message' => 'Created Successfully','document' => $request->document]);

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
