<?php

namespace App\Http\Controllers;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Illuminate\support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
use App\Models\category;
use App\Models\subcategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    function subcategory(){
        return view('admin.sub_category.index');
    }
    function getcategory(){
     $categores =category::all();
       return response()->json([
         'categores' =>$categores,
       ]);
    }
    function insert(Request $request){
        $request->validate([
            'sub_category_name'=>'unique:subcategories',
        ]);
        $subcategory = new subcategory();
        $subcategory->sub_category_name = $request->Sub_category_name;
        $subcategory->category_id = $request->category_id;
        $subcategory->created_at = Carbon::now();
        $subcategory->save();
        return response()->json(['success'=>"Added successfully."]); 
    }
    function get_subcategory(){
        $subcategory = subcategory::all();
        return response()->json([
            'subcategory' =>$subcategory,
          ]);
    }
}
