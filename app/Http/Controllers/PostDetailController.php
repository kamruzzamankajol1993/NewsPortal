<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subcategory;
use DB;
use App\Adver;
use App\User;
use App\PostCategory;
use App\Post;
use App\Video;
use Illuminate\Support\Facades\Session;
class PostDetailController extends Controller
{
    public function post($id){
      
        
        
   $categories=DB::table('post_categories')->where('status',1)->orderBy('image','asc')->limit(11)->get();
        $latestPosts=DB::table('post_categories')->where('status',1)->orderBy('image','asc')->skip(12)->take(8)->get();
        $latestPosts1=DB::table('post_categories')->where('status',1)->orderBy('image','asc')->skip(11)->take(1)->get();
        
       $catad=Adver::where('name','category_Section')->orderBy('id','desc')->limit(1)->get(); 

  
        
       $covs=DB::table('post_categories')->where('status',1)->orderBy('id','asc')->skip(5)->take(3)->get();

        $latestPosts=DB::table('post_categories')->where('status',1)->skip(8)->take(9)->get();
        $latestPosts1=DB::table('post_categories')->where('status',1)->skip(17)->take(1)->get();
        $topFours=DB::table('post_categories')->where('status',1)->skip(18)->take(16)->get();

        $subcats=SubCategory::where('cat_name',21)->get();

         $mcats=DB::table('post_categories')->where('status',1)->skip(5)->limit(12)->get();

       $latestheadline9s = Post::latest()->skip(3)->take(6)->get();
    $postCatname=PostCategory::where('id',$id)->value('name');
    $postCatid=PostCategory::where('id',$id)->value('id');
    //$postsubCatname=SubCategory::where('sub_name',$subid)->value('sub_name');
    $newses=DB::table('posts')->where('category_id',$id)->orderBy('id','desc')->paginate(12);
$latestheadlines = Post::latest()->take(3)->get();
$latestheadline2s = Post::latest()->skip(3)->take(4)->get();
        $footers = Post::latest()->limit(5)->get();

        $f1= PostCategory::where('status',1)->limit(4)->get();
$f2= PostCategory::where('status',1)->skip(4)->limit(4)->get();
$f3= PostCategory::where('status',1)->skip(8)->limit(4)->get();

    return view('front.postCategory.postCategory')->with([
      'f1'=>$f1,
        'f2'=>$f2,
        'f3'=>$f3,
        'catad'=>$catad,
        'mcats'=>$mcats,
        'covs'=>$covs,
        'latestPosts1'=>$latestPosts1,
        'latestheadline9s'=>$latestheadline9s,
        
     'latestPosts'=>$latestPosts,
     'topFours'=>$topFours,
     'categories'=>$categories,
     'subcats'=>$subcats,
     'postCatname'=>$postCatname,
     'postCatid'=>$postCatid,
     'newses'=>$newses,
     'latestheadlines'=>$latestheadlines,
     'latestheadline2s'=>$latestheadline2s,
      'footers'=>$footers,
    ]);
    }

    public function subpost($id){

      $f1= PostCategory::where('status',1)->limit(4)->get();
$f2= PostCategory::where('status',1)->skip(4)->limit(4)->get();
$f3= PostCategory::where('status',1)->skip(8)->limit(4)->get();
        $categoryad=Gallery1::where('name','category_Section')->orderBy('id','desc')->limit(1)->get();
        $headerad=Gallery1::where('name','Header_Section')->orderBy('id','desc')->limit(1)->get();
      $categories=DB::table('post_categories')->where('status',1)->orderBy('image','asc')->limit(11)->get();
        $latestPosts=DB::table('post_categories')->where('status',1)->orderBy('image','asc')->skip(12)->take(8)->get();
        $latestPosts1=DB::table('post_categories')->where('status',1)->orderBy('image','asc')->skip(11)->take(1)->get();
        
       $covs=DB::table('post_categories')->where('status',1)->orderBy('id','asc')->skip(5)->take(3)->get();

     
        $topFours=DB::table('post_categories')->where('status',1)->skip(18)->take(16)->get();

        $subcats=SubCategory::where('cat_name',21)->get();

         $mcats=DB::table('post_categories')->where('status',1)->skip(5)->limit(12)->get();

       $latestheadline9s = Post::latest()->skip(3)->take(6)->get();
    $postCatname=SubCategory::where('id',$id)->value('sub_name');
    $postCatid=SubCategory::where('id',$id)->value('id');
    //$postsubCatname=SubCategory::where('sub_name',$subid)->value('sub_name');
    $newses=DB::table('posts')->where('subcategory_id',$id)->orderBy('id','desc')->paginate(6);
$latestheadlines = Post::latest()->take(3)->get();
$latestheadline2s = Post::latest()->skip(3)->take(4)->get();
        $footers = Post::latest()->limit(5)->get();

    return view('front.postCategory.subpostCategory')->with([
      'f1'=>$f1,
        'f2'=>$f2,
        'f3'=>$f3,
        'categoryad'=>$categoryad,
        'mcats'=>$mcats,
        'covs'=>$covs,
        'latestPosts1'=>$latestPosts1,
        'latestheadline9s'=>$latestheadline9s,
     'latestPosts'=>$latestPosts,
     'topFours'=>$topFours,
     'categories'=>$categories,
     'subcats'=>$subcats,
     'postCatname'=>$postCatname,
     'newses'=>$newses,
     'latestheadlines'=>$latestheadlines,
     'latestheadline2s'=>$latestheadline2s,
      'footers'=>$footers,
      'postCatid'=>$postCatid,
      'headerad'=>$headerad,
    ]);
    }

    public function postSingle($id){

      $f1= PostCategory::where('status',1)->limit(4)->get();
$f2= PostCategory::where('status',1)->skip(4)->limit(4)->get();
$f3= PostCategory::where('status',1)->skip(8)->limit(4)->get();

      $users=User::all();
          
        $totalView=DB::table('posts')->where('id',$id)->value('total_share');
        $update=$totalView+1;
        Db::table('posts')->where('id',$id)->update(['total_share'=>$update]);
       $categories=DB::table('post_categories')->where('status',1)->orderBy('image','asc')->limit(11)->get();
        $latestPosts=DB::table('post_categories')->where('status',1)->orderBy('image','asc')->skip(12)->take(8)->get();
        $latestPosts1=DB::table('post_categories')->where('status',1)->orderBy('image','asc')->skip(11)->take(1)->get();
        
       $covs=DB::table('post_categories')->where('status',1)->orderBy('id','asc')->skip(5)->take(3)->get();

        
        $topFours=DB::table('post_categories')->where('status',1)->skip(18)->take(16)->get();

        $subcats=SubCategory::where('cat_name',21)->get();

         $mcats=DB::table('post_categories')->where('status',1)->skip(5)->limit(12)->get();

       $latestheadline9s = Post::latest()->skip(3)->take(6)->get();
    	$subcat1s=PostCategory::all();
       
        $news=DB::table('posts')->Where('id','=',$id)->first();
        $r=DB::table('posts')->Where('id','=',$id)->value('category_id');
               
      $latestheadlines = Post::latest()->take(5)->get();

       $randomposts = Post::where('category_id',$r)->take(4)->inRandomOrder()->get();
   $famousposts = Post::where('status',1)->take(5)->orderBy('total_share','desc')->get();
    $latestheadline2s = Post::latest()->skip(3)->take(4)->get();
        $footers = Post::latest()->limit(5)->get();

        // get the current user
    $user = Post::find($id);

    // get previous user id
    $previous = Post::where('id', '<', $user->id)->max('id');
    $pnews=DB::table('posts')->Where('id','=',$previous)->first();

    // get next user id
    $next = Post::where('id', '>', $user->id)->min('id');
    $nnews=DB::table('posts')->Where('id','=',$next)->first();


    $latestId= Post::orderBy('id','desc')->limit(1)->value('id');
    $firstId=Post::orderBy('id','asc')->limit(1)->value('id');


    	return view('front.postCategory.singlePost')->with([
        'f1'=>$f1,
        'f2'=>$f2,
        'f3'=>$f3,
    	   'users'=>$users,
           'mcats'=>$mcats,
        'covs'=>$covs,
        'latestPosts1'=>$latestPosts1,
        'latestheadline9s'=>$latestheadline9s,
     'latestPosts'=>$latestPosts,
     'topFours'=>$topFours,
     'categories'=>$categories,
     'subcats'=>$subcats,
     'news'=>$news,
     'latestheadlines'=>$latestheadlines,
     'randomposts'=>$randomposts,
     'famousposts'=>$famousposts,
     'latestheadline2s'=>$latestheadline2s,
      'footers'=>$footers,
      'subcat1s'=>$subcat1s,
      'next'=>$next,
      'previous'=>$previous,
      'nnews'=>$nnews,
      'pnews'=>$pnews,
      'latestId'=>$latestId,
      'firstId'=>$firstId,
    
    ]);
    }

    public function subpostSingle($id){

      $f1= PostCategory::where('status',1)->limit(4)->get();
$f2= PostCategory::where('status',1)->skip(4)->limit(4)->get();
$f3= PostCategory::where('status',1)->skip(8)->limit(4)->get();
         $singlecategoryad=Gallery1::where('name','singlecategory_Section')->orderBy('id','desc')->limit(1)->get();
        $headerad=Gallery1::where('name','Header_Section')->orderBy('id','desc')->limit(1)->get();
        $totalView=DB::table('posts')->where('id',$id)->value('total_share');
        $update=$totalView+1;
        Db::table('posts')->where('id',$id)->update(['total_share'=>$update]);

      $categories=DB::table('post_categories')->where('status',1)->orderBy('image','asc')->limit(11)->get();
        $latestPosts=DB::table('post_categories')->where('status',1)->orderBy('image','asc')->skip(12)->take(8)->get();
        $latestPosts1=DB::table('post_categories')->where('status',1)->orderBy('image','asc')->skip(11)->take(1)->get();
        
       $covs=DB::table('post_categories')->where('status',1)->orderBy('id','asc')->skip(5)->take(3)->get();

       
        $topFours=DB::table('post_categories')->where('status',1)->skip(18)->take(16)->get();

        $subcats=SubCategory::where('cat_name',21)->get();

         $mcats=DB::table('post_categories')->where('status',1)->skip(5)->limit(12)->get();

       $latestheadline9s = Post::latest()->skip(3)->take(6)->get();
        
        $news=DB::table('posts')->Where('id','=',$id)->first();
      $latestheadlines = Post::latest()->take(10)->get();
      $r=DB::table('posts')->Where('id','=',$id)->value('subcategory_id');
     $randomposts = Post::where('subcategory_id',$r)->take(4)->inRandomOrder()->get();
     $famousposts = Post::where('status',1)->take(10)->orderBy('total_share','desc')->get();
     $latestheadline2s = Post::latest()->skip(3)->take(4)->get();
        $footers = Post::latest()->limit(5)->get();
        // get the current user
    $user = Post::find($id);

    // get previous user id
    $previous = Post::where('id', '<', $user->id)->max('id');
    $pnews=DB::table('posts')->Where('id','=',$previous)->first();

    // get next user id
    $next = Post::where('id', '>', $user->id)->min('id');
    $nnews=DB::table('posts')->Where('id','=',$next)->first();

    $latestId= Post::orderBy('id','desc')->limit(1)->value('id');
    $firstId=Post::orderBy('id','asc')->limit(1)->value('id');


        return view('front.postCategory.subsinglePost')->with([
          'f1'=>$f1,
        'f2'=>$f2,
        'f3'=>$f3,
            'singlecategoryad'=>$singlecategoryad,
           'mcats'=>$mcats,
        'covs'=>$covs,
        'latestPosts1'=>$latestPosts1,
        'latestheadline9s'=>$latestheadline9s,
     'latestPosts'=>$latestPosts,
     'topFours'=>$topFours,
     'categories'=>$categories,
     'subcats'=>$subcats,
     'news'=>$news,
     'latestheadlines'=>$latestheadlines,
     'randomposts'=>$randomposts,
     'famousposts'=>$famousposts,
     'latestheadline2s'=>$latestheadline2s,
      'footers'=>$footers,
      'next'=>$next,
      'previous'=>$previous,
      'nnews'=>$nnews,
      'pnews'=>$pnews,
      'latestId'=>$latestId,
      'firstId'=>$firstId,
      'headerad'=>$headerad,
     
    ]);
    }

     public function search(Request $request)
    {

      $f1= PostCategory::where('status',1)->limit(4)->get();
$f2= PostCategory::where('status',1)->skip(4)->limit(4)->get();
$f3= PostCategory::where('status',1)->skip(8)->limit(4)->get();
         $categories=DB::table('post_categories')->where('status',1)->orderBy('image','asc')->limit(11)->get();
        $latestPosts=DB::table('post_categories')->where('status',1)->orderBy('image','asc')->skip(12)->take(8)->get();
        $latestPosts1=DB::table('post_categories')->where('status',1)->orderBy('image','asc')->skip(11)->take(1)->get();
       $subcats=Subcategory::where('cat_name',21)->get();
        $latestheadline9s = Post::latest()->skip(3)->take(6)->get();
        $latestheadline2s = Post::latest()->skip(3)->take(4)->get();
        $footers = Post::latest()->limit(5)->get();
       $latestheadlines = Post::latest()->take(3)->get();

$search_txt = $request->input('query');
        $newses = Post::where('status',1)
                           ->where('title', 'like', '%'.$search_txt.'%')
                ->orWhere('paragraph', 'like', '%'.$search_txt.'%')
                ->orWhere('category_id', 'like', '%'.$search_txt.'%')
                ->get();


    return view('front.search.search')->with([
      'f1'=>$f1,
        'f2'=>$f2,
        'f3'=>$f3,
       'latestPosts1'=>$latestPosts1,
        'latestheadline9s'=>$latestheadline9s,
     'latestPosts'=>$latestPosts,
     
     'categories'=>$categories,
     'subcats'=>$subcats,
     //'postCatname'=>$postCatname,
     'newses'=>$newses,
     'latestheadlines'=>$latestheadlines,
     'search_txt'=>$search_txt,
     'latestheadline2s'=>$latestheadline2s,
      'footers'=>$footers,
    ]);
    }


     public function today($id){

      $f1= PostCategory::where('status',1)->limit(4)->get();
$f2= PostCategory::where('status',1)->skip(4)->limit(4)->get();
$f3= PostCategory::where('status',1)->skip(8)->limit(4)->get();
          $singlecategoryad=Gallery1::where('name','singlecategory_Section')->orderBy('id','desc')->limit(1)->get();
        $headerad=Gallery1::where('name','Header_Section')->orderBy('id','desc')->limit(1)->get();
       
      $categories=DB::table('post_categories')->where('status',1)->orderBy('image','asc')->limit(11)->get();
        $latestPosts=DB::table('post_categories')->where('status',1)->orderBy('image','asc')->skip(12)->take(8)->get();
        $latestPosts1=DB::table('post_categories')->where('status',1)->orderBy('image','asc')->skip(11)->take(1)->get();
        
       $covs=DB::table('post_categories')->where('status',1)->orderBy('id','asc')->skip(5)->take(3)->get();

        
        $topFours=DB::table('post_categories')->where('status',1)->skip(18)->take(16)->get();

        $subcats=SubCategory::where('cat_name',21)->get();

         $mcats=DB::table('post_categories')->where('status',1)->skip(5)->limit(12)->get();

       $latestheadline9s = Post::latest()->skip(3)->take(6)->get();
    	$subcat1s=PostCategory::all();
       
        $news=DB::table('videos')->find($id);
        $r=Video::Where('id','=',$id)->value('cat_id');
               
      $latestheadlines = Post::latest()->take(10)->get();

       $randomposts = Post::where('category_id',$r)->take(4)->inRandomOrder()->get();
   $famousposts = Post::where('status',1)->take(10)->orderBy('total_share','desc')->get();
    $latestheadline2s = Post::latest()->skip(3)->take(4)->get();
        $footers = Post::latest()->limit(5)->get();

        // get the current user
    $user = Video::find($id);

    // get previous user id
    $previous = Video::where('id', '<', $user->id)->max('id');
    $pnews=DB::table('videos')->Where('id','=',$previous)->first();

    // get next user id
    $next = Video::where('id', '>', $user->id)->min('id');
    $nnews=DB::table('Videos')->Where('id','=',$next)->first();


    $latestId= Video::orderBy('id','desc')->limit(1)->value('id');
    $firstId=Video::orderBy('id','asc')->limit(1)->value('id');


    	return view('front.postCategory.today')->with([
        'f1'=>$f1,
        'f2'=>$f2,
        'f3'=>$f3,
    	    'singlecategoryad'=>$singlecategoryad,
    	    'headerad'=>$headerad,
           'mcats'=>$mcats,
        'covs'=>$covs,
        'latestPosts1'=>$latestPosts1,
        'latestheadline9s'=>$latestheadline9s,
     'latestPosts'=>$latestPosts,
     'topFours'=>$topFours,
     'categories'=>$categories,
     'subcats'=>$subcats,
     'news'=>$news,
     'latestheadlines'=>$latestheadlines,
     'randomposts'=>$randomposts,
     'famousposts'=>$famousposts,
     'latestheadline2s'=>$latestheadline2s,
      'footers'=>$footers,
      'subcat1s'=>$subcat1s,
      'next'=>$next,
      'previous'=>$previous,
      'nnews'=>$nnews,
      'pnews'=>$pnews,
      'latestId'=>$latestId,
      'firstId'=>$firstId,
    
    ]);
    }

     public function first(){
      $f1= PostCategory::where('status',1)->limit(4)->get();
$f2= PostCategory::where('status',1)->skip(4)->limit(4)->get();
$f3= PostCategory::where('status',1)->skip(8)->limit(4)->get();
       $categories=DB::table('post_categories')->where('status',1)->limit(2)->get();
        
       $covs=DB::table('post_categories')->where('status',1)->orderBy('id','asc')->skip(5)->take(3)->get();

        $latestPosts=DB::table('post_categories')->where('status',1)->skip(8)->take(9)->get();
        $latestPosts1=DB::table('post_categories')->where('status',1)->skip(17)->take(1)->get();
        $topFours=DB::table('post_categories')->where('status',1)->skip(18)->take(10)->get();

        $subcats=SubCategory::where('cat_name',21)->get();

         $mcats=DB::table('post_categories')->where('status',1)->skip(5)->limit(12)->get();

       $latestheadline9s = Post::latest()->skip(3)->take(6)->get();
        //$subcats=SubCategory::all();
    //$postCatname=PostCategory::where('id',$id)->value('name');
    //$postCatid=PostCategory::where('id',$id)->value('id');
    //$postsubCatname=SubCategory::where('sub_name',$subid)->value('sub_name');
    $newses=DB::table('posts')->inRandomOrder()->limit(50)->paginate(6);
$latestheadlines = Post::latest()->take(3)->get();
$latestheadline2s = Post::latest()->skip(3)->take(4)->get();
        $footers = Post::latest()->limit(5)->get();

    return view('front.postCategory.first')->with([
      'f1'=>$f1,
        'f2'=>$f2,
        'f3'=>$f3,
        
      'mcats'=>$mcats,
        'covs'=>$covs,
        'latestPosts1'=>$latestPosts1,
        'latestheadline9s'=>$latestheadline9s,
        
     'latestPosts'=>$latestPosts,
     'topFours'=>$topFours,
     'categories'=>$categories,
     'subcats'=>$subcats,
     //'postCatname'=>$postCatname,
     //'postCatid'=>$postCatid,
     'newses'=>$newses,
     'latestheadlines'=>$latestheadlines,
     'latestheadline2s'=>$latestheadline2s,
      'footers'=>$footers,
    ]);
    }

    public function last(){
      $f1= PostCategory::where('status',1)->limit(4)->get();
$f2= PostCategory::where('status',1)->skip(4)->limit(4)->get();
$f3= PostCategory::where('status',1)->skip(8)->limit(4)->get();
        $categories=DB::table('post_categories')->where('status',1)->limit(2)->get();
        
       $covs=DB::table('post_categories')->where('status',1)->orderBy('id','asc')->skip(5)->take(3)->get();

        $latestPosts=DB::table('post_categories')->where('status',1)->skip(8)->take(9)->get();
        $latestPosts1=DB::table('post_categories')->where('status',1)->skip(17)->take(1)->get();
        $topFours=DB::table('post_categories')->where('status',1)->skip(18)->take(10)->get();

        $subcats=SubCategory::where('cat_name',21)->get();

         $mcats=DB::table('post_categories')->where('status',1)->skip(5)->limit(12)->get();

       $latestheadline9s = Post::latest()->skip(3)->take(6)->get();
        //$subcats=SubCategory::all();
    //$postCatname=PostCategory::where('id',$id)->value('name');
    //$postCatid=PostCategory::where('id',$id)->value('id');
    //$postsubCatname=SubCategory::where('sub_name',$subid)->value('sub_name');
    $newses=DB::table('posts')->inRandomOrder()->limit(50)->paginate(6);
$latestheadlines = Post::latest()->take(3)->get();
$latestheadline2s = Post::latest()->skip(3)->take(4)->get();
        $footers = Post::latest()->limit(5)->get();

    return view('front.postCategory.last')->with([
      'f1'=>$f1,
        'f2'=>$f2,
        'f3'=>$f3,
       'mcats'=>$mcats,
        'covs'=>$covs,
        'latestPosts1'=>$latestPosts1,
        'latestheadline9s'=>$latestheadline9s,
     'latestPosts'=>$latestPosts,
     'topFours'=>$topFours,
     'categories'=>$categories,
     'subcats'=>$subcats,
     //'postCatname'=>$postCatname,
     //'postCatid'=>$postCatid,
     'newses'=>$newses,
     'latestheadlines'=>$latestheadlines,
     'latestheadline2s'=>$latestheadline2s,
      'footers'=>$footers,
    ]);
    }
}
