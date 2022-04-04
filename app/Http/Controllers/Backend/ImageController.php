<?php

namespace App\Http\Controllers\Backend;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
{
    public function createproduct(Request $request){
        $validator = Validator::make($request->all(),[
            'image'        => 'required|mime:png,jpg,jpeg',
            'product_id'   => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        
        foreach($request->file('image') as $imagefile){
        $image = new Image;
        $path = $imagefile->store('/images/resource', ['disk' => 'my_files']);
        $image->image = $path;
        $image->product_id = $product->id;
        $image->save();
    }
}
}
