<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    //user view
    public function UserView(){
    //   $allData = User::all();
    $data['allData'] = User::all();
      return view('backend.user.view_user',$data);
    }

    // user add method

    public function AddUser(){

        return view('backend.user.add_user');

    }

    // user store method
    public function UserStore(Request  $request){

        $validateData = $request->validate([
            'email' => 'required|unique:users',
            'name' =>'required',
        ]);

        $data = new User();
        $data->usertype =$request->usertype;
        $data->name =$request->name;
        $data->email =$request->email;
        $data->password =bcrypt($request->password);
        $data->save();
        $notification = array(
            'message' => 'User inserted Successfully',
            'alert-type'=> 'success',
        );

            return redirect()->route('user.view')->with($notification);
        }

    // user edit
    public function UserEdit($id){
        $editData = User::find($id);
        return view('backend.user.edit_user',compact('editData'));
    }

    // user update function

    public function UserUpdate(Request $request, $id){

        $data = User::find($id);
        $data->usertype =$request->usertype;
        $data->name =$request->name;
        $data->email =$request->email;
        $data->save();
        $notification = array(
            'message' => 'User Updated  Successfully',
            'alert-type'=> 'info',
        );

            return redirect()->route('user.view')->with($notification);
    }

    // user data delete method

    public function UserDelete($id){
        $user = User::find($id)->delete();
        $notification = array(
            'message' => 'User Deleted  Successfully',
            'alert-type'=> 'warning',
        );

            return redirect()->route('user.view')->with($notification);
    }
}
