<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;

class AccountController extends Controller
{
    public function index()
    {
        $data = Account::orderby('id','DESC')->get();
        return view('admin.account.index', compact('data'));
    }
}
