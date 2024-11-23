<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\BusinessPartner;
use App\Models\User;
use App\Models\Client;
use App\Models\Country;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index()
    {
        $data = Client::where('user_id', Auth::user()->id)->orderby('id','DESC')->get();
        $countries = Country::orderby('id','DESC')->get();
        $accounts = Account::orderby('id','DESC')->get();
        $bpartners = BusinessPartner::orderby('id','DESC')->get();
        return view('manager.client.index', compact('data','countries','accounts','bpartners'));
    }

    public function processing()
    {
        $data = Client::where('user_id', Auth::user()->id)->where('status','0')->orderby('id','DESC')->get();
        $agents = User::where('is_type','2')->get();
        $countries = Country::orderby('id','DESC')->get();
        $accounts = Account::orderby('id','DESC')->get();
        $bpartners = BusinessPartner::orderby('id','DESC')->get();
        return view('manager.client.index', compact('data','countries','accounts','bpartners'));
    }

    public function decline()
    {
        $data = Client::where('user_id', Auth::user()->id)->where('status','2')->orderby('id','DESC')->get();
        $agents = User::where('is_type','2')->get();
        $countries = Country::orderby('id','DESC')->get();
        $accounts = Account::orderby('id','DESC')->get();
        $bpartners = BusinessPartner::orderby('id','DESC')->get();
        return view('manager.client.index', compact('data','countries','accounts','bpartners'));
    }

    public function completed()
    {
        $data = Client::where('user_id', Auth::user()->id)->where('status','1')->orderby('id','DESC')->get();
        $agents = User::where('is_type','2')->get();
        $countries = Country::orderby('id','DESC')->get();
        $accounts = Account::orderby('id','DESC')->get();
        $bpartners = BusinessPartner::orderby('id','DESC')->get();
        return view('manager.client.index', compact('data','countries','accounts','bpartners'));
    }
}
