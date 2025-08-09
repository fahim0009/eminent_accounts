<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CodeMaster;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;

class CodeMasterController extends Controller
{
    public function index()
    {
        $data = CodeMaster::get();
        return view('admin.setting.index', compact('data'));
    }

    public function store(Request $request)
    {
        if(empty($request->name)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Name \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        $chkname = CodeMaster::where('type_name',$request->name)->first();
        if($chkname){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>This name already added.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        $data = new CodeMaster;
        $data->type = $request->type;
        $data->type_code = $request->type_code;
        $data->type_name = $request->name;
        $data->type_description = $request->type_description;
        $data->created_by = Auth::user()->id;
        if ($data->save()) {
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Create Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }

    public function edit($id)
    {
        $where = [
            'id'=>$id
        ];
        $info = CodeMaster::where($where)->get()->first();
        return response()->json($info);
    }

    public function update(Request $request)
    {
        if(empty($request->name)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Username \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        $duplicatename = CodeMaster::where('type_name',$request->name)->where('id','!=', $request->codeid)->first();
        if($duplicatename){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>This name already added.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }


        $data = CodeMaster::find($request->codeid);
        $data->type_name = $request->name;
        $data->updated_by = Auth::user()->id;
        if ($data->save()) {
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Updated Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }
        else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        } 
    }

    public function delete($id)
    {

        if(CodeMaster::destroy($id)){
            return response()->json(['success'=>true,'message'=>'Data has been deleted successfully']);
        }else{
            return response()->json(['success'=>false,'message'=>'Delete Failed']);
        }
    }

    // rl details 
    public function rlView()
    {

    $activeData = CodeMaster::where('status', 1)->where('type', 'RL')->get();
    $inactiveData = CodeMaster::where('status', 0)->where('type', 'RL')->get();

    return view('admin.rl.index', compact('activeData', 'inactiveData'));

    }

    public function toggleStatusAjax(Request $request)
    {
    
        $user = CodeMaster::findOrFail($request->id);
        $user->status = $request->status;
        $user->save();

        return response()->json(['status' => 200, 'message' => 'Status updated successfully.']);

    }


    public function rlDetails($rlid)
    {
        if (!$rlid || !is_numeric($rlid)) {
            abort(404);
        }
    
        $clients = Client::leftJoin(DB::raw("
                (
                    SELECT mh1.*
                    FROM mofa_histories mh1
                    INNER JOIN (
                        SELECT client_id, MAX(date) AS latest_date
                        FROM mofa_histories
                        WHERE rlid = $rlid
                        GROUP BY client_id
                    ) mh2 ON mh1.client_id = mh2.client_id AND mh1.date = mh2.latest_date
                    WHERE mh1.rlid = $rlid
                ) AS latest_mofa
            "), 'clients.id', '=', 'latest_mofa.client_id')
            ->leftJoin(DB::raw("
                (
                    SELECT client_id, COUNT(*) AS mofa_count
                    FROM mofa_histories
                    WHERE rlid = $rlid
                    GROUP BY client_id
                ) AS mofa_counts
            "), 'clients.id', '=', 'mofa_counts.client_id')
            ->select(
                'clients.*',
                'latest_mofa.date',
                'latest_mofa.client_id as mh_client_id',
                'latest_mofa.mofa_trade',
                'latest_mofa.note',
                'latest_mofa.status as mh_status',
                DB::raw('IFNULL(mofa_counts.mofa_count, 0) as mofa_count')
            )
            ->whereExists(function ($query) use ($rlid) {
                $query->select(DB::raw(1))
                    ->from('mofa_histories')
                    ->whereRaw('mofa_histories.client_id = clients.id')
                    ->where('mofa_histories.rlid', $rlid);
            })
            ->orderBy('clients.id', 'ASC')
            ->get();
            
       
    $clientsNew = $clients->where('status', 0)->values();
    $clientsProcessing = $clients->where('status', 1)->values();
    $clientsCompleted = $clients->where('status', 2)->values();

    return view('admin.rl.rldetails', [
        'clientsNew' => $clientsNew,
        'clientsProcessing' => $clientsProcessing,
        'clientsCompleted' => $clientsCompleted,
    ]);




    }
    
 
    
    

}
