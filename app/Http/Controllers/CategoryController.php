<?php

namespace App\Http\Controllers;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Illuminate\support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\category;
class CategoryController extends Controller
{
    function category(){
        $getcat=category::all();
        return view('admin.category.index',[
            'getcat'=>$getcat,
        ]);
    }
    function cat_insert(Request $request){
        $request->validate([
            'category_name'=>'required',
            'category_photo'=>'image',
            'category_photo'=>'file|max:2056',
            'category_name'=>'unique:categories',
        ]);
       if($request->category_name == ""){
          return back()->with('Categoryerr','Category Fild Must be fillup');
       }
       else{
        $cat_id =  category::insertGetId([
            'user_id'=>Auth::id(),
            'category_name'=>$request->category_name,
            'category_photo'=>'d',
            'created_at'=>Carbon::now(),
         ]);
         $upload_photo=$request->category_photo;
         $extension=$upload_photo->getClientOriginalExtension();
         $file_name=$cat_id.'.'.$extension;
         Image::make($upload_photo)->save(public_path('/uploads/category/'.$file_name));
            category::find($cat_id)->update([
                'category_photo'=>$file_name,
            ]);
         return back()->with('succes','category Added Done');
       }
    }
    function cat_edit_page($cat_editid){
        $cat_info=category::find($cat_editid);
        return view('admin.category.edit',[
            'cat_info'=>$cat_info,
        ]);
    }
    function cat_edit(Request $request){
        $request->validate([
            'category_name'=>'required',
            'category_photo'=>'image',
            'category_photo'=>'file|max:2056',
            'category_name'=>'unique:categories',
        ]);
        if($request->category_name != ""){
            category::find($request->id)->update([
                'user_id'=>Auth::id(),
                'category_name'=>$request->category_name,
                'update_at'=>Carbon::now(),
              ]);
              $delete_from=public_path('/uploads/category/'.category::find($request->id)->category_photo);
              unlink($delete_from);
              $upload_photo=$request->category_photo;
              $extension=$upload_photo->getClientOriginalExtension();
              $file_name=$request->id.'.'.$extension;
              Image::make($upload_photo)->save(public_path('/uploads/category/'.$file_name));
                 category::find($request->id)->update([
                     'category_photo'=>$file_name,
                 ]);
         return back()->with('succes','category Added Done');
       }
       else{
        return back()->with('Categoryerr','Category Filds Must be fillup');
       }
    }
    function catagory_soft_delete($id){
         category::find($id)->delete();
         return response()->json(['success'=>"Products Deleted successfully."]);
        // return back()->with('delete','Category deletion Done');
    }
    function mark_delete(Request $request){
       
        $ids = $request->ids;  
         category::whereIn('id', explode(",",$ids))->delete();
         return response()->json(['success'=>"Products Deleted successfully."]);
            
        
    }
    function trushed(){
        $trash_cat=category::onlyTrashed()->get();
        return view('admin.category.trush',[
         'trash_cat'=>$trash_cat,
        ]);
    }
    function hard_delete(Request $request){
        $ids = $request->ids;
        category::onlyTrashed()->whereIn('id', explode(",",$ids))->forceDelete();
        return response()->json(['success'=>"Products Deleted successfully."]);
    }
    function restore($restore_id){
     category::where('id', $restore_id)->restore();
     return response()->json(['success'=>"Products Restored successfully."]);
   }
}
