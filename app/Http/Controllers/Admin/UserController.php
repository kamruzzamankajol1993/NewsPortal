<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;

class UserController extends Controller
{

	public function index(){

		$users=User::all();

		return view('admin.user.manage',['users'=>$users]);
	}


	public function delete($id)
    {
         User::find($id)->delete();
         Toastr::warning('User Successfully Deleted :)','Warning');
         return redirect()->back();
    }

    public function approval($id)
              {
        $agent = User::find($id);
        if ($agent->role_id   == 0)
           {
            $agent->role_id = 2;
            $agent->save();
            Toastr::info('User Successfully Approved :)','Info');
           }
           
           return redirect()->back();
    }

     public function inactive($id)
              {
        $agent = User::find($id);
        if ($agent->role_id   == 2)
           {
            $agent->role_id = 0;
            $agent->save();
            Toastr::info('User Successfully Inactive :)','Info');
           }
           
           return redirect()->back();
    }


    public function create(){

    	return view('admin.user.register');
    }

    public function store(Request $request){
     
      $request->validate([
    	     'name'=>'required',
             'email'=>'required',
             'password'=>'required',
             'phone'=>'required',
             

              ]);

    	$agent = new User();
        $agent->name=$request->name;
        $agent->phone = $request->phone;
        $agent->email = $request->email;
        $agent->password = Hash::make($request->password);
       
        $agent->save();

        Toastr::success('User Successully Added :)' ,'Success');
             return redirect()->back();
    }


    public function edit($id){
       
        $agent=User::find($id);
        return view('admin.user.edit',['agent'=>$agent]);

    }

    public function update(Request $request){

      DB::table('users')->where('id',$request->id)->update(['name'=>$request->name,'email'=>$request->email,'phone'=>$request->phone,'password'=>Hash::make($request->password)]);
      Toastr::success('User Successfully Updated :)','Success');
        return redirect()->route('admin.user');
    }
   
}
