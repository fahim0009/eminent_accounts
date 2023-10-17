<?php

namespace App\Http\Controllers;

use App\Models\Work;
use App\Models\BlogCategory;
Use Image;
use Illuminate\support\Facades\Auth;
use Illuminate\Http\Request;

class WorkController extends Controller
{
    public function index()
    {
        $data = Work::orderby('id','DESC')->get();
        return view('admin.work.index',compact('data'));
    }
    
    public function store(Request $request)
    {
        $data = new Work();
        $data->title = $request->title;
        $data->bg_color = $request->bg_color;
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
        $info = Work::where($where)->get()->first();
        return response()->json($info);
    }

    public function update(Request $request, $id)
    {
        
        $updatedata = Work::find($id);
        if($request->image != 'null'){
            $oldimg = Work::where('id','=', $id)->first();
            if ($oldimg->image == '') {
            }else{
                $imgdata = Work::find($id);
                $image_path = public_path('images').'/'.$imgdata->image;
                unlink($image_path);
                $thumbnail_path = public_path('images/thumbnail').'/'.$imgdata->image;
                unlink($thumbnail_path);
            }

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
       
            $updatedata->title = $request->title;
            $updatedata->bg_color = $request->bg_color;
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

        $dltdata = Work::where('id','=', $id)->first();
        if ($dltdata->image != '') {
            $image_path = public_path('images').'/'.$dltdata->image;
            unlink($image_path);
            $thumbnail_path = public_path('images/thumbnail').'/'.$dltdata->image;
            unlink($thumbnail_path);
        }

        if(Work::destroy($id)){
            return response()->json(['success'=>true,'message'=>'Listing Deleted']);
        }
        else{
            return response()->json(['success'=>false,'message'=>'Update Failed']);
        }
    }
}
