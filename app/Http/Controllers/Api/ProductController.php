<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request){
        $validator = Validator::make($request->all(),[
            'category_id'   => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        
        $myString = $request->category_id;
      
        $product = DB::table("products")
        ->select('id','title','description','price','status','sku','image')
        ->whereRaw("find_in_set('".$myString."',products.category_id)")
        ->get();
        
        return response()->json(['result'=>$product]);
    }
    
    public function search(Request $request, $id){
        $query = Product::select('id','title','description','price','status','sku','image')->where('id',$id)->first();
        if($query){
        return response()->json(['result'=>$query]);
        }else{
            return response()->json(['error'=>'No Data Found']); 
        }
    }
}
