<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;
use App\Adver;
use Brian2694\Toastr\Facades\Toastr;
use DB;
use Illuminate\Support\Facades\Auth;
class AdvertisementController extends Controller
{
      public function create()
    {
         return view('admin.gallery.addPhoto');
    }

    protected function imageUpload($request){
        $productImage = $request->file('image');
        $imageName = $productImage->getClientOriginalName();
        $directory = 'gallery-image/';
        $imageUrl = $directory.$imageName;
    
        Image::make($productImage)->save($imageUrl);

        return $imageUrl;
    }

     protected function saveProductInfo($request, $imageUrl){
        $item = new Adver();
        $item->name = $request->name;
        $item->user_id=Auth::id();
        $item->status = $request->status;
        $item->image = $imageUrl;
       if($item->save()){
        Toastr::success('Successully Added :)' ,'Success');
            return redirect()->route('admin.advertisement')->with('message','Saved succesfully');

        }
    }
    public function store(Request $request)
    {
        $this->validate($request,[
           
           
            'name' => 'required',
            'image' => 'required',
            'status' => 'required'
        ]);
        $imageUrl = $this->imageUpload($request);
        $this->saveProductInfo($request, $imageUrl);

      
        //Toastr::success('Successully Added :)' ,'Success');
        return redirect()->route('admin.advertisement');
    }

    public function index()
    {
    	$categories=Adver::all();
    return view('admin.gallery.manageGallery')->with(['categories'=>$categories]);
    }

    public function destroy($id){
        $banner = Adver::find($id);
        $banner->delete();
Toastr::warning('Successfully Deleted :)','Warning');
        return redirect()->route('admin.advertisement');
    }
    
    public function edit($id){

        $post=Adver::find($id);
        return view('admin.gallery.photoEdit')->with(['post'=>$post]);

    }
    
     public function productInfoUpdate($request, $imageUrl){

        $item=DB::table('advers')->where('id',$request->id)->update(['image'=>$imageUrl,'name'=>$request->name]);
    }

    public function  update(Request $request){

        $productImage = $request->file('image');

        if($request->hasFile('image')){
            $post = Adver::find($request->id);
            $oldImage=$post->image;
            unlink($post->image);
         
            $imageUrl = $this->imageUpload($request);
            $this->productInfoUpdate($request, $imageUrl);
           Toastr::success('Successully Updated :)' ,'Success');
           return redirect()->route('admin.advertisement')->with('message','Updated Successfully');

        }else{
           $item=DB::table('advers')->where('id',$request->id)->update(['name'=>$request->name]);
           Toastr::success('Successully Updated :)' ,'Success');
            return redirect()->route('admin.advertisement')->with('message','Updated Successfully');
        }
}
}
