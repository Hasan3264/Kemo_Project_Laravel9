<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
class AdminController extends Controller
{
    function users(){
        $get_all_user= User::where('id', '!=', Auth::id())->paginate(2);
        $total_user=User::count();
        return view('admin.user.users',[
            'get_all_user'=>$get_all_user,
            'total_user'=>$total_user,
        ]);
    }
    function users_delete($user_id){
        User::find($user_id)->delete();
        return back()->with('delete','Deletion Done');
    }
    function user_profile(){
        return view('admin.user.userprofile');
    }
    function name_up(Request $request){
        $request->validate([
        'name'=>'required'
        ]);
        $user_id = User::find(Auth::id());
        $user_id->name=$request->name;
        $user_id->save();
         return response()->json('user_id');
    }
    function pass_Update(Request $request){
        $request->validate([
            'old_password'=>'required',
            'password'=>'required',
            'password'=>Password::min(8)
                       ->letters()
                       ->numbers(),
            'password'=>'confirmed',
        ]);
        if(\Hash::check($request->old_password, Auth::user()->password)){
            if(\Hash::check($request->password, Auth::user()->password)){
                return back()->with('exiest_pass','Password was tacken for This Gmail!');
            }
            else{
                User::find(Auth::id())->update([
                   'password'=>bcrypt($request->password),
                   'updated_at'=>Carbon::now(),
                ]);
                return back()->with('updated_pass','Password hasbeen changed!');
            }
         }
         else{
               return back()->with('wrong_pass','Old Password not correct!');
         }
    }
    function Update_profile(Request $request){
        $request->validate([
            'profile_photo'=>'image',
            'profile_photo'=>'file|max:2056',
           ]);
           $upload_photo=$request->profile_photo;
             $extension=$upload_photo->getClientOriginalExtension();
             $file_name=Auth::id().'.'.$extension;
            if(Auth::user()->profile_photo == 'default.jpg'){
                Image::make($upload_photo)->save(public_path('/uploads/admins/'.$file_name));
                User::where('id',Auth::id())->update([
                    'profile_photo'=>$file_name,
                ]);
                 return back()->with('update_photo','Photo Updated');
            }
            else{
                $delete_from=public_path('/uploads/admins/'.Auth::user()->profile_photo);
                unlink($delete_from);
                Image::make($upload_photo)->save(public_path('/uploads/admins/'.$file_name));
                User::find(Auth::id())->update([
                    'profile_photo'=>$file_name,
                ]);
                return back()->with('update_photo','Photo Updated');
            }
    }
}
