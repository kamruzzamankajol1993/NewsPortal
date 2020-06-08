<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PostCategory;
use App\subCategory;
use App\Post;
use Image;
use DB;
use App\AssignCategory;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
class VideoController extends Controller
{
     public function create()
    {
        $categories=PostCategory::where('id','=',52)->get();
    return view('user.video.addVideo')->with(['categories'=>$categories]);
    }

    

  protected function audioUpload($request){
        $audiofile = $request->file('cover_image');
        $audioName = $audiofile->getClientOriginalName();
        $extension = $audiofile->getClientOriginalExtension();
        //$imageName = $productImage->getClientOriginalName();
       
        $directory = 'video-admin/';
        $audioUrl = $directory.$audioName;
    
        $audiofile->move($directory, $audioUrl);

        //Image::make($productImage)->resize(300,300)->save($imageUrl);

       return  $audioName;
    }



     protected function saveaudio($request, $audiofile){
        $video = new Post();
        $video->title=$request->title;
        $video->caption=$request->caption;
        $video->op_title=$request->op_title;
        $video->total_view=$request->total_view;
         $video->category_id=$request->category_id;
        $video->cover_image = $audiofile;
        $video->paragraph=$request->content; 
        $video->status = $request->status;
        if($video->save()){
            Toastr::success('Successully Added :)' ,'Success');
        return redirect()->route('admin.addvideo');

        }

    }

    public function store(Request $request){
        $video = new Post();
        $video->user_id=Auth::id();
        $video->title=$request->title;
        $video->caption=$request->caption;
        $video->op_title=$request->op_title;
        $video->total_view=$request->total_view;
         $video->category_id=$request->category_id;
        $video->cover_image = $request->cover_image;
        $video->paragraph=$request->content; 
        $video->status = $request->status;
        if($video->save()){
            Toastr::success('Successully Added :)' ,'Success');
        return redirect()->route('user.video');

        }
    }


    public function index()
    {
        $categories=Auth::user()->posts()->where('category_id',52)->get();
    return view('user.video.manageVideo')->with(['categories'=>$categories]);
    }

    public function detail($id)
    {
        $post=Post::where('id',$id)->first();
        return view('user.video.postDetails')->with(['post'=>$post]);
    }
    
    public function destroy($id)
    {
        DB::table('posts')->where('id',$id)->delete();
        Toastr::warning('Successfully Deleted :)','Warning');
        return redirect()->route('user.video');
    }
    
    public function edit($id){

        $post=Post::find($id);
        return view('user.video.edit')->with(['post'=>$post]);

    }
    
  public function update(Request $request, $id){


        $video = Post::find($id);
          $video->user_id=Auth::id();
        $video->title=$request->title;
        $video->caption=$request->caption;
        $video->op_title=$request->op_title;
        $video->total_view=$request->total_view;
        $video->paragraph=$request->content; 
        $video->cover_image=$request->cover_image;
       

        $video->save();
       
         Toastr::success('Successfully Updated :)','Success');
        return redirect()->route('user.video');
     
    }
}
