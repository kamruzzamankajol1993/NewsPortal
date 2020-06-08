<?php

namespace App\Http\Controllers\Admin;

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
        $cats=Post::paginate(12);
    $categories=PostCategory::all();
    $subcategories=SubCategory::all();
    return view('admin.post.addPost')->with(['cats'=>$cats,'categories'=>$categories,'subcategories'=>$subcategories]);
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
           return redirect()->route('admin.post')->with('message','Saved succesfully');

       
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
        return redirect()->route('admin.post');

    	
    }

    public function index()
    {
        $cats=PostCategory::all();
    	$allPost=Post::all();
    	return view('admin.post.managePost')->with(['allPost'=>$allPost,'cats'=>$cats]);
    }

    


    public function detail($id)
    {
    	$post=Post::where('id',$id)->first();
    	return view('admin.post.postDetails')->with(['post'=>$post]);
    }

    public function destroy($id)
    {
        DB::table('posts')->where('id',$id)->delete();
        Toastr::warning('Successfully Deleted :)','Warning');
        return redirect()->route('admin.post');
    }

    public function edit($id){

        $post=Post::find($id);
        return view('admin.post.postEdit')->with(['post'=>$post]);

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
           return redirect()->route('admin.post')->with('message','Updated Successfully');

        }else{
           $item=DB::table('posts')->where('id',$request->id)->update(['title'=>$request->title,'paragraph'=>$request->paragraph,'total_view'=>$request->total_view]);
           Toastr::success('Successully Updated :)' ,'Success');
            return redirect()->route('admin.post')->with('message','Updated Successfully');
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
}
