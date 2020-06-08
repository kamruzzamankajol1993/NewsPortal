<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PostCategory;
use App\Subcategory;
use App\Post;
use Illuminate\Support\Facades\Auth;
use Image;
use DB;
use App\AssignCategory;
use Brian2694\Toastr\Facades\Toastr;

class PostController extends Controller
{
    public function create()
    {
    $categories=PostCategory::all();
    $subcategories=SubCategory::all();
    return view('user.post.addPost')->with(['categories'=>$categories,'subcategories'=>$subcategories]);
    }

	 protected function imageUpload($request){
        $productImage = $request->file('cover_image');
        $imageName = $productImage->getClientOriginalName();
        $directory = 'gallery-image/';
        $imageUrl = $directory.$imageName;
    
        Image::make($productImage)->resize(700,390)->save($imageUrl);

        return $imageUrl;
    }
   

     protected function saveProductInfo($request, $imageUrl){


        $number=count($request->category_id);

        if($number >0){
            for($i=0;$i<$number;$i++){
                $data=array([
                    'category_id'=>$request->category_id[$i],
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
        /*$post=new Post;
        $post->title=$request->title;
        //$post->subcategory_id=$request->subcategory_id;
        //$post->category_id=$request->category_id;
        $post->paragraph=$request->content; 
        $post->total_view=$request->total_view;
        $post->status=$request->status;
        $post->cover_image=$imageUrl;
        $post->save();
        $postid=$post->id;
        foreach($request->category_id as $cat){
            $postCat=new AssignCategory;
            $postCat->post_id=$postid;
            $postCat->cat_id=$cat;
            $postCat->save();
        }*/
       
        Toastr::success('Successully Added :)' ,'Success');
           return redirect()->route('user.post')->with('message','Saved succesfully');

       
    }

    public function store(Request $request)
    {
       

        $request->validate([
        'title'=>'required',
        'content'=>'required',
        
        ]);

        $imageUrl = $this->imageUpload($request);
        $this->saveProductInfo($request, $imageUrl);
        
       
        
       //Toastr::success('Successully Added :)' ,'Success');
        return redirect()->route('user.post');

    	
    }

    public function index()
    {
        $cats=PostCategory::all();
    	$allPost=Auth::user()->posts()->latest()->get();
    	return view('user.post.managePost')->with(['allPost'=>$allPost,'cats'=>$cats]);
    }

    


    public function detail($id)
    {
    	$post=Post::where('id',$id)->first();
    	return view('user.post.postDetails')->with(['post'=>$post]);
    }

    public function destroy($id)
    {
        DB::table('posts')->where('id',$id)->delete();
        Toastr::warning('Successfully Deleted :)','Warning');
        return redirect()->route('user.post');
    }

    public function edit($id){

        $post=Post::find($id);
        return view('user.post.postEdit')->with(['post'=>$post]);

    }

    public function productInfoUpdate($request, $imageUrl){

        $item=DB::table('posts')->where('id',$request->id)->update(['cover_image'=>$imageUrl,'title'=>$request->title,'paragraph'=>$request->paragraph,'total_view'=>$request->total_view]);
    }

    public function  update(Request $request){

        $productImage = $request->file('cover_image');

        if($request->hasFile('cover_image')){
            $post = Post::find($request->id);
            $oldImage=$post->cover_image;
            unlink($post->cover_image);
         
            $imageUrl = $this->imageUpload($request);
            $this->productInfoUpdate($request, $imageUrl);
           Toastr::success('Successully Updated :)' ,'Success');
           return redirect()->route('user.post')->with('message','Updated Successfully');

        }else{
           $item=DB::table('posts')->where('id',$request->id)->update(['title'=>$request->title,'paragraph'=>$request->paragraph,'total_view'=>$request->total_view]);
           Toastr::success('Successully Updated :)' ,'Success');
            return redirect()->route('user.post')->with('message','Updated Successfully');
        }
}


    public function postCategoryDetail($id){
        
      $postList=DB::table('assign_categories')
                  ->leftjoin('posts','posts.id','=','assign_categories.post_id')
                  ->select('posts.*')
                  ->where('assign_categories.cat_id',$id)
                  ->get();
                  
        $category=DB::table('post_categories')->where('id',$id)->first();
       

    return view('user.postCategory.postCategory')->with([
     'postList'=>$postList,
     'category'=>$category,
    ]);

        
    }
    
    
    public function divindex()
    {
        $postcategories=Auth::user()->posts()->whereIn('category_id',[55,56,57,58,59,60,61,62])->get();
    	$categories= Subcategory::all();
    return view('user.division.manage')->with(['categories'=>$categories,'postcategories'=>$postcategories]);
    }
    
    public function divcreate()
    {
        $subcategories=Subcategory::all();
        $categories=PostCategory::whereIn('id',[55,56,57,58,59,60,61,62])->get();
    return view('user.division.add',['categories'=>$categories,'subcategories'=>$subcategories]);
    }
    
    //to show subcategory filed in service page
    public function findProductName(Request $request){

        $data=Subcategory::select('sub_name')->where('cat_name',$request->id)->get();
        return response()->json($data);
    }
    
    protected function imageUpload1($request){
        $productImage = $request->file('cover_image');
        $imageName = $productImage->getClientOriginalName();
        $directory = 'gallery-image/';
        $imageUrl = $directory.$imageName;
    
        Image::make($productImage)->resize(700,390)->save($imageUrl);

        return $imageUrl;
    }
   

     protected function saveProductInfo1($request, $imageUrl){

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
           return redirect()->route('user.division_news')->with('message','Saved succesfully');

       
    }

    public function divstore(Request $request)
    {
       

        $request->validate([
        'title'=>'required',
        'content'=>'required',
        
        ]);

        $imageUrl = $this->imageUpload1($request);
        $this->saveProductInfo1($request, $imageUrl);
        
       
        
       //Toastr::success('Successully Added :)' ,'Success');
        return redirect()->route('user.division_news');

    	
    }
    
    public function divdetail($id)
    {
    	$post=Post::where('id',$id)->first();
    	return view('user.division.detail')->with(['post'=>$post]);
    }

    public function divdestroy($id)
    {
        DB::table('posts')->where('id',$id)->delete();
        Toastr::warning('Successfully Deleted :)','Warning');
        return redirect()->route('user.division_news');
    }

    public function divedit($id){

        $post=Post::find($id);
        return view('user.division.edit')->with(['post'=>$post]);

    }

    public function productInfoUpdate1($request, $imageUrl){

        $item=DB::table('posts')->where('id',$request->id)->update(['cover_image'=>$imageUrl,'title'=>$request->title,'paragraph'=>$request->paragraph,'total_view'=>$request->total_view]);
    }

    public function  divupdate(Request $request){

        $productImage = $request->file('cover_image');

        if($request->hasFile('cover_image')){
            $post = Post::find($request->id);
            $oldImage=$post->cover_image;
            unlink($post->cover_image);
         
            $imageUrl = $this->imageUpload1($request);
            $this->productInfoUpdate1($request, $imageUrl);
           Toastr::success('Successully Updated :)' ,'Success');
           return redirect()->route('user.division_news')->with('message','Updated Successfully');

        }else{
           $item=DB::table('posts')->where('id',$request->id)->update(['title'=>$request->title,'paragraph'=>$request->paragraph,'total_view'=>$request->total_view]);
           Toastr::success('Successully Updated :)' ,'Success');
            return redirect()->route('user.division_news')->with('message','Updated Successfully');
        }
}
}
