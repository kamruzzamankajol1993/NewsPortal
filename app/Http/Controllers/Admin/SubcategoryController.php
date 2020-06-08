<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PostCategory;
use App\Subcategory;
use DB;
use Brian2694\Toastr\Facades\Toastr;
use App\Post;
use Image;
use Illuminate\Support\Facades\Auth;
class SubcategoryController extends Controller
{
    public function create()
    {
        $categories=PostCategory::whereIn('id',[55,56,57,58,59,60,61,62])->get();
    return view('admin.subcategory.addCategory',['categories'=>$categories]);
    }

    public function store(Request $request)
    {
    	$request->validate([
         'sub_name'=>'required',
    	]);
    	$cat=new Subcategory;
    	$cat->cat_name=$request->cat_name;
    	$cat->sub_name=$request->sub_name;
    	$cat->status=$request->status;
    	$cat->save();
    	Toastr::success('Successully Added :)' ,'Success');
    	return redirect()->route('admin.subcategory.create');

    }
    public function index()
    {
        $postcategories=PostCategory::whereIn('id',[55,56,57,58,59,60,61,62])->get();
    	$categories= Subcategory::all();
    return view('admin.subcategory.manage')->with(['categories'=>$categories,'postcategories'=>$postcategories]);
    }

    public function destroy($id)
    {
         DB::table('subcategories')->where('id',$id)->delete();
         Toastr::warning('Successfully Deleted :)','Warning');
        return redirect()->route('admin.subcategory');
    }

    public function edit($id){

        $cat= Subcategory::find($id);
        return view('admin.subcategory.editCategory')->with(['cat'=>$cat]);

    }


    public function update(Request $request){

      DB::table('subcategories')->where('id',$request->id)->update(['sub_name'=>$request->sub_name]);
      Toastr::success('Successfully Updated :)','Success');
        return redirect()->route('admin.subcategory');
    }
    
    public function divindex()
    {
        $postcategories=Post::whereIn('category_id',[55,56,57,58,59,60,61,62])->get();
    	$categories= Subcategory::all();
    return view('admin.division.manage')->with(['categories'=>$categories,'postcategories'=>$postcategories]);
    }
    
    public function divcreate()
    {
         $cats=Post::paginate(12);
        $subcategories=Subcategory::all();
        $categories=PostCategory::whereIn('id',[55,56,57,58,59,60,61,62])->get();
    return view('admin.division.add',['cats'=>$cats,'categories'=>$categories,'subcategories'=>$subcategories]);
    }
    
    //to show subcategory filed in service page
    public function findProductName(Request $request){

        $data=Subcategory::select('sub_name')->where('cat_name',$request->id)->get();
        return response()->json($data);
    }
    
    protected function imageUpload($request){
       if($request->hasfile('cover_image')){
        $productImage = $request->file('cover_image');
        $imageName = $productImage->getClientOriginalName();
        $directory = 'gallery-image/';
        $imageUrl = $directory.$imageName;
    
        Image::make($productImage)->resize(700,390)->save($imageUrl);

        return $imageUrl;
    }else{
            

             $imageUrl= $request->cover_image;
             return $imageUrl;

    }
    }
   

     protected function saveProductInfo($request, $imageUrl){

         $number=count($request->subcategory_id);

        if($number >0){
            for($i=0;$i<$number;$i++){
                $data=array([
                    'subcategory_id'=>$request->subcategory_id[$i],
                    'category_id'=>$request->category_id,
                    'title'=>$request->title,
                    'user_id'=>Auth::id(),
                    'op_title'=>$request->op_title,
                    'caption'=>$request->caption,
                    'paragraph'=>$request->content,
                    'total_view'=>$request->total_view,
                    'status'=>$request->status,
                    'created_at'=>$request->created_at,
                    'cover_image'=>$imageUrl
                ]);
                
               Post::insert($data);
            }

        }
        
        Toastr::success('Successully Added :)' ,'Success');
           return redirect()->route('admin.division_news')->with('message','Saved succesfully');

       
    }

    public function divstore(Request $request)
    {
       

        $request->validate([
        'title'=>'required',
        'content'=>'required',
        
        ]);

        $imageUrl = $this->imageUpload($request);
        $this->saveProductInfo($request, $imageUrl);
        
       
        
       //Toastr::success('Successully Added :)' ,'Success');
        return redirect()->route('admin.division_news');

    	
    }
    
    public function divdetail($id)
    {
    	$post=Post::where('id',$id)->first();
    	return view('admin.division.detail')->with(['post'=>$post]);
    }

    public function divdestroy($id)
    {
        DB::table('posts')->where('id',$id)->delete();
        Toastr::warning('Successfully Deleted :)','Warning');
        return redirect()->route('admin.division_news');
    }

    public function divedit($id){

        $post=Post::find($id);
        return view('admin.division.edit')->with(['post'=>$post]);

    }

    public function productInfoUpdate($request, $imageUrl){

        $item=DB::table('posts')->where('id',$request->id)->update(['cover_image'=>$imageUrl,'title'=>$request->title,'paragraph'=>$request->paragraph,'total_view'=>$request->total_view]);
    }

    public function  divupdate(Request $request){

        $productImage = $request->file('cover_image');

        if($request->hasFile('cover_image')){
            $post = Post::find($request->id);
            $oldImage=$post->cover_image;
            unlink($post->cover_image);
         
            $imageUrl = $this->imageUpload($request);
            $this->productInfoUpdate($request, $imageUrl);
           Toastr::success('Successully Updated :)' ,'Success');
           return redirect()->route('admin.division_news')->with('message','Updated Successfully');

        }else{
           $item=DB::table('posts')->where('id',$request->id)->update(['title'=>$request->title,'paragraph'=>$request->paragraph,'total_view'=>$request->total_view]);
           Toastr::success('Successully Updated :)' ,'Success');
            return redirect()->route('admin.division_news')->with('message','Updated Successfully');
        }
}
}
