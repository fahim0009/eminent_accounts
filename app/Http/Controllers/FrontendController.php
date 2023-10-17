<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Job;
use App\Models\AgentRequest;
use Illuminate\Http\Request;
use Mail;

class FrontendController extends Controller
{
    public function index()
    {
        return view('frontend.index');
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function blog()
    {
        return view('frontend.blog');
    }

    public function blogDetails($id)
    {
        $data = Blog::where('id',$id)->first();
        return view('frontend.blogdtl', compact('data'));
    }

    public function job()
    {
        return view('frontend.job');
    }

    public function jobCategory()
    {
        return view('frontend.jobcategory');
    }

    public function jobdtl($id)
    {
        $data = Job::where('id',$id)->first();
        return view('frontend.jobdtl', compact('data'));
    }

    public function becomeAnAgent()
    {
        return view('frontend.becomeagent');
    }

    public function becomeAnAgentStore(Request $request)
    {

        $this->validate($request,[
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required'
            ]);

        $user = new AgentRequest;
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;


        if($user->save()){
            
            $mail['phone']=$request->phone;
            $mail['name']=$request->name;
            $mail['address']=$request->address;
            $mail['subject']="Become an agent Mail";


            $email_to = "fahim.amin71@gmail.com";
            Mail::send('email.becomeagent', compact('mail'), function($message)use($mail,$email_to) {
                $message->from('info@eminentint.com', 'Eminent International');
                $message->to($email_to)
                ->subject($mail["subject"]);
                });

            $message ="Message Send Successfully";
            return back()->with('message', $message);
        }
        return back()->with(['status'=> 303,'message'=>'Server Error!!']);


    }


}
