<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobCategory;
use App\Models\AgentRequest;
Use Image;
use Illuminate\support\Facades\Auth;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $data = Job::orderby('id','DESC')->get();
        return view('admin.job.index',compact('data'));
    }
    
    public function store(Request $request)
    {
        $data = new Job();
        $data->title = $request->title;
        $data->location = $request->location;
        $data->address = $request->address;
        $data->category_id = $request->category_id;
        $data->description = $request->description;

        // intervention
        if ($request->image != 'null') {
            $originalImage= $request->file('image');
            $thumbnailImage = Image::make($originalImage);
            $thumbnailPath = public_path().'/images/thumbnail/';
            $originalPath = public_path().'/images/';
            $time = time();
            $thumbnailImage->save($originalPath.$time.$originalImage->getClientOriginalName());
            $thumbnailImage->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $thumbnailImage->save($thumbnailPath.$time.$originalImage->getClientOriginalName());
            $data->image= $time.$originalImage->getClientOriginalName();
        }
        if ($request->banner_image != 'null') {
            $originalImage= $request->file('banner_image');
            $thumbnailImage = Image::make($originalImage);
            $thumbnailPath = public_path().'/images/thumbnail/';
            $originalPath = public_path().'/images/';
            $time = time();
            $thumbnailImage->save($originalPath.$time.$originalImage->getClientOriginalName());
            $thumbnailImage->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $thumbnailImage->save($thumbnailPath.$time.$originalImage->getClientOriginalName());
            $data->banner_image = $time.$originalImage->getClientOriginalName();
        }
        // end

        $data->slug = $request->slug;
        $data->status= "0";
        $data->created_by= Auth::user()->id;
        if ($data->save()) {
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Created Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        } else {
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }

    public function edit($id)
    {
        $where = [
            'id'=>$id
        ];
        $info = Job::where($where)->get()->first();
        return response()->json($info);
    }

    public function update(Request $request, $id)
    {
        
        $updatedata = Job::find($id);

        if($request->image != 'null'){
            
                $originalImage= $request->file('image');
                $thumbnailImage = Image::make($request->file('image')->getRealPath());
                $thumbnailPath = public_path().'/images/thumbnail/';
                $originalPath = public_path().'/images/';
                $time = time();
                $thumbnailImage->save($originalPath.$time.$originalImage->getClientOriginalName());
                $thumbnailImage->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $thumbnailImage->save($thumbnailPath.$time.$originalImage->getClientOriginalName());
                $updatedata->image = $time.$originalImage->getClientOriginalName();
          
        }
       
        if($request->banner_image != 'null'){
            
                $originalBannerImage = $request->file('banner_image');
                $thumbnailBannerImage = Image::make($request->file('banner_image')->getRealPath());
                $thumbnailBannerPath = public_path().'/images/thumbnail/';
                $originalBannerPath = public_path().'/images/';
                $btime = time();
                $thumbnailBannerImage->save($originalBannerPath.$btime.$originalBannerImage->getClientOriginalName());
                $thumbnailBannerImage->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $thumbnailBannerImage->save($thumbnailBannerPath.$btime.$originalBannerImage->getClientOriginalName());
                $updatedata->banner_image= $btime.$originalBannerImage->getClientOriginalName();
        
        }

            $updatedata->title = $request->title;
            $updatedata->address = $request->address;
            $updatedata->location = $request->location;
            $updatedata->category_id = $request->category_id;
            $updatedata->description = $request->description;
            $updatedata->status = "1";
            $updatedata->updated_by= Auth::user()->id;

        if ($updatedata->save()) {
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Updated Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }

    public function delete($id)
    {

        // $dltdata = Job::where('id','=', $id)->first();
        // if ($dltdata->image != '') {
        //     $image_path = public_path('images').'/'.$dltdata->image;
        //     unlink($image_path);
        //     $thumbnail_path = public_path('images/thumbnail').'/'.$dltdata->image;
        //     unlink($thumbnail_path);
        // }

        if(Job::destroy($id)){
            return response()->json(['success'=>true,'message'=>'Listing Deleted']);
        }
        else{
            return response()->json(['success'=>false,'message'=>'Update Failed']);
        }
    }



    public function category()
    {
        $data = JobCategory::orderby('id','DESC')->get();
        return view('admin.job.category',compact('data'));
    }
    
    public function categorystore(Request $request)
    {
        $data = new JobCategory();
        $data->name= $request->name;

        // intervention
        if ($request->image != 'null') {
            $originalImage= $request->file('image');
            $thumbnailImage = Image::make($originalImage);
            $thumbnailPath = public_path().'/images/thumbnail/';
            $originalPath = public_path().'/images/';
            $time = time();
            $thumbnailImage->save($originalPath.$time.$originalImage->getClientOriginalName());
            $thumbnailImage->resize(150,150);
            $thumbnailImage->save($thumbnailPath.$time.$originalImage->getClientOriginalName());
            $data->image= $time.$originalImage->getClientOriginalName();
        }
        // end

        $data->slug= $request->slug;
        $data->status= "0";
        $data->created_by= Auth::user()->id;
        if ($data->save()) {
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Created Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        } else {
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }

    public function categoryedit($id)
    {
        $where = [
            'id'=>$id
        ];
        $info = JobCategory::where($where)->get()->first();
        return response()->json($info);
    }

    public function categoryupdate(Request $request, $id)
    {
        $data = JobCategory::find($id);

        if($request->image != 'null'){

            $oldimg = JobCategory::where('id','=', $id)->first();
            if ($oldimg->image == '') {
                
            }else{
                $image_path = public_path('images').'/'.$data->image;
                unlink($image_path);
                $thumbnail_path = public_path('images/thumbnail').'/'.$data->image;
                unlink($thumbnail_path);
            }
            $originalImage= $request->file('image');
            if ($request->file('image')) {
                $thumbnailImage = Image::make($request->file('image')->getRealPath());
                $thumbnailPath = public_path().'/images/thumbnail/';
                $originalPath = public_path().'/images/';
                $time = time();
                $thumbnailImage->save($originalPath.$time.$originalImage->getClientOriginalName());
                $thumbnailImage->resize(370,324);
                $thumbnailImage->save($thumbnailPath.$time.$originalImage->getClientOriginalName());
                $data->image= $time.$originalImage->getClientOriginalName();
            }
        }
            $data->name = $request->name;
            $data->slug = $request->slug;
            $data->status = "1";

        if ($data->save()) {
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Updated Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }

    public function categorydelete($id)
    {

        $data = JobCategory::where('id','=', $id)->first();
        if ($data->image != '') {
            $image_path = public_path('images').'/'.$data->image;
            unlink($image_path);
            $thumbnail_path = public_path('images/thumbnail').'/'.$data->image;
            unlink($thumbnail_path);
        }

        if(JobCategory::destroy($id)){
            return response()->json(['success'=>true,'message'=>'Listing Deleted']);
        }
        else{
            return response()->json(['success'=>false,'message'=>'Update Failed']);
        }
    }

    public function getAgentRequest()
    {
        $data = AgentRequest::orderby('id','DESC')->get();
        return view('admin.job.agentrequest',compact('data'));
    }
}
