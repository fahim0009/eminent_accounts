<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

class MofaController extends Controller
{
    public function index()
    {
        
        $clients = DB::table('clients')
            ->leftJoin('code_masters as mofa_code_masters', 'clients.mofa_trade', '=', 'mofa_code_masters.id') // First join
            ->leftJoin('code_masters as rlid_code_masters', 'clients.rlid', '=', 'rlid_code_masters.id') // Second join
            ->leftJoin('users', 'clients.user_id', '=', 'users.id') // Join users table
            ->select(
                'clients.*', 
                'mofa_code_masters.type_name as mofa_trade', // Type name for mofa_trade
                'rlid_code_masters.type_name as rlname', // Type name for rlid
                'users.id as user_id', 
                'users.name as user_name', 
                'users.surname as user_surname'
            )
            ->where('clients.status', '0')
            ->where('clients.mofa_request', '1')
            ->orderBy('clients.id', 'ASC')
            ->get();


        $count = $clients->count();
        

        return view("admin.mofa.index", compact('clients','count'));
    }
}
