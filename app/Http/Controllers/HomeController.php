<?php
  
namespace App\Http\Controllers;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (auth()->user()->is_type == '1') {
            return redirect()->route('admin.dashboard');
        }else if (auth()->user()->is_type == '2') {
            return redirect()->route('manager.dashboard');
        }else if (auth()->user()->is_type == '0') {
            return redirect()->route('user.home');
        }else{
            return redirect()->route('home');
        }
    } 
  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminHome()
    {
        $new = Client::where('status','0')->count();
        $processing = Client::where('status','1')->count();
        $decline = Client::where('status','3')->count();
        $completed = Client::where('status','2')->count();

        $tickets = Client::where('is_ticket','1')->where('status','1')->count();

        $datas = DB::table('transactions')
        ->select(
            DB::raw('COALESCE(SUM(CASE WHEN tran_type IN ("package_received", "package_discount") THEN bdt_amount ELSE 0 END), 0) as total_visareceived'),
            DB::raw('COALESCE(SUM(CASE WHEN tran_type IN ("okala_received", "okalasales_discount") THEN bdt_amount ELSE 0 END), 0) as total_okalareceived'),
            DB::raw('COALESCE(SUM(CASE WHEN tran_type IN ("okala_sales", "okalasales_adon") THEN bdt_amount ELSE 0 END), 0) as total_okalapackage'),
            DB::raw('COALESCE(SUM(CASE WHEN tran_type IN ("package_sales", "package_adon") THEN bdt_amount ELSE 0 END), 0) as total_package'),
            DB::raw('COALESCE(SUM(CASE WHEN tran_type IN ("service_sales", "service_adon") THEN bdt_amount ELSE 0 END), 0) as total_service'),
            DB::raw('COALESCE(SUM(CASE WHEN tran_type IN ("service_received", "service_discount") THEN bdt_amount ELSE 0 END), 0) as total_serviceReceived')
        )
        ->first();

        return view('admin.dashboard', compact('new','processing','decline','completed','datas','tickets'));
    }
  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function managerHome(): View
    {
        return view('manager.dashboard');
    }
}