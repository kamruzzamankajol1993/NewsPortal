<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PostCategory;
use App\Subcategory;
use App\Post;


class DashboardController extends Controller
{
    public function index()
    {
    	$category_count = PostCategory::all()->count();
        $subcategory_count = Subcategory::all()->count();
        $post_count = Post::all()->count();
        $view_count = Post::where('category_id',19)->count();
        $posts =Post::latest()->limit(5)->get();
        $cats=PostCategory::all();

    	return view('admin.dashboard',['category_count'=>$category_count,'subcategory_count'=>$subcategory_count,'post_count'=>$post_count,'view_count'=>$view_count,'posts'=>$posts,'cats'=>$cats]);
    }
}
