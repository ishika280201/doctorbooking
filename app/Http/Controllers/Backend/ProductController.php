<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Image;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Request $request){
        if($request->ajax()){
            $data = Product::select('*');
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn1 = '<a href="javascript:void(0)" id="'.$row->id.'"  class="edit btn btn-primary btn-sm">Edit</a>
                <a href="javascript:void(0)" id="'.$row->id.'" class="delete btn btn-danger btn-sm">Delete</a>';
                return $btn1;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        $product = Category::where('status','active')->get();
        return view('backend.product.list',compact('product'));
    }

    public function create(Request $request){
            $validator = Validator::make($request->all(),[
              'title'   => 'required',
              'description' => 'required',
              'price'  => 'required',
              'category_id' => 'required',
              'sku'    => 'required',
              'image'   => 'required',
              //'status'   => 'required'
            ]);
            if($validator->fails()){
                return response()->json(['errors'=>$validator->errors()->all()]);
            }

            $productImage = $request->file('image');
            $productImageName = rand() . '.' . $productImage->getClientOriginalExtension();
            $productImage->move(public_path('img/products'), $productImageName);
            

           // $categorys = implode(",", );
             $formdata = new Product;
             $formdata->id = $request->id;
             $formdata->title = $request->title;
             $formdata->description = $request->description;
             $formdata->image = $request->image; 
             $formdata->category_id = $request->category_id;
             $formdata->sku = $request->sku;
             $formdata->image = $productImageName;
             $formdata->status = $request->status;
             $formdata->save();


             $productImageName1 = rand() . '.' . $productImage->getClientOriginalExtension();
             $Imageimg = new Image;
             $Imageimg->image = $productImageName1;
             $Imageimg->product_id = $formdata->id;
             $Imageimg->save();

             $product = Category::where('status','active')->get();
           
            return response()->json(['success'=>'Data Added Successfully']); 
          }

          public function edit($id){
            if(request()->ajax()){
              $data = Product::findOrFail($id);
              return response()->json(['result'=>$data]);
              
            }
          }
      
          public function update(Request $request, Product $product){
              $rules = array(
                'title'   => 'required',
                'description' => 'required',
                'price'  => 'required',
                'category_id' => 'required',
                'sku'    => 'required',
               // 'image'  => 'required',
                'status'   => 'required',
              );
      
              $validator  = Validator::make($request->all(), $rules);
              if($validator->fails()){
                return response()->json(['errors'=>$validator->errors()->all()]);
              }

              // $product->update($request->all());
              $product  = Product::find($request->id);
              $product-> title = $request->title;
              $product-> description = $request->description;     
              $product-> price = $request->price;        
              $product-> category_id = $request->category_id;        
             // $product-> image = $request->image;        
              $product-> status = $request->status;            
            
              if($request->image != 'undefined'){
                if($request->hasFile('image')){
                $file = $request->file('image');
                $destinationPath = public_path(). '/img/products';
                $filename = $file->getClientOriginalName();
                $file->move($destinationPath, $filename);
        
                //then proceeded to save user
                $user-> image = $filename;
        
                $user->save();
                }
            }else{
             
            }
              
              Product::where('id',$request->hidden_id1);
              return response()->json(['success' => 'Data Successfully Updated']);
          
        }


          public function destroy($id)
          {
            $data = Product::findOrFail($id);
              $data->delete();
          }
}
