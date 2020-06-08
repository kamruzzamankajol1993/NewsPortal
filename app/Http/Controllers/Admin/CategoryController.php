<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PostCategory;
use App\Post;
use DB;
use Brian2694\Toastr\Facades\Toastr;

class CategoryController extends Controller
{
    public function create()
    {
        $cat= Post::all();
    return view('admin.category.addCategory')->with(['cat'=>$cat]);
    }

    public function store(Request $request)
    {
    	$request->validate([
         'name'=>'required',
    	]);
    	$cat=new PostCategory;
    	$cat->name=$request->name;
    	$cat->status=$request->status;
    	$cat->save();
    	Toastr::success('Successully Added :)' ,'Success');
    	return redirect()->route('admin.category');

    }
    public function index()
    {
    	$categories= DB::table('post_categories')->where('status',1)->orderBy('image','asc')->get();
    return view('admin.category.manageCategory')->with(['categories'=>$categories]);
    }

    public function destroy($id)
    {
         DB::table('post_categories')->where('id',$id)->delete();
         Toastr::warning('Successfully Deleted :)','Warning');
        return redirect()->route('admin.category');
    }

    public function edit($id){

        $cat= PostCategory::find($id);
        return view('admin.category.editCategory')->with(['cat'=>$cat]);

    }


    public function update(Request $request){

      DB::table('post_categories')->where('id',$request->id)->update(['name'=>$request->name]);
      Toastr::success('Successfully Updated :)','Success');
        return redirect()->route('admin.category');
    }


      public function updateItems(Request $request)
    {
        

        if($request->has('ids')){
            $arr = explode(',',$request->input('ids'));
            
            foreach($arr as $sortOrder => $id){
                $menu = PostCategory::find($id);
                $menu->image = $sortOrder;
                $menu->save();
            }
            return ['success'=>true,'message'=>'Updated'];
        }
  
    }
}
