<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    
    public function index(Request $request){
        if($request->ajax()){
            $data = Category::select('*');
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
        return view('backend.category.list');
    }
    
    public function create(Request $request){
      $validator = Validator::make($request->all(),[
        'title'   => 'required',
        'description' => 'required',
        'module'  => 'required',
        'priority' => 'required',
       // 'image'    => 'required',
        'status'   => 'required'
      ]);
      if($validator->fails()){
          return response()->json(['errors'=>$validator->errors()->all()]);
      }
       $form_data = array(
         'id'   => $request->id,
         'title'   => $request->title,
         'description' => $request->description,
         'module'  => $request->module,
         'priority' => $request->priority,
       //  'image'    => $request->image,
         'status'   => $request->status,
       );

       Category::create($form_data);
      return response()->json(['success'=>'Data Added Successfully']); 
    }

    public function show()
    {
        
    }


    public function edit($id){
      if(request()->ajax()){
        $data = Category::findOrFail($id);
        return response()->json(['result'=>$data]);
      }
    }

    public function update(Request $request){
        $rules = array(
          'title'        => 'required',
          'description'  => 'required',
          'module'       => 'required',
          'priority'     => 'required',
          'status'       => 'required',
        );

        $validator  = Validator::make($request->all(), $rules);
        if($validator->fails()){
          return response()->json(['errors'=>$validator->errors()->all()]);
        }
        $form_data = array(
          'title'        => $request->title,
          'description'  => $request->description,
          'module'       => $request->module,
          'priority'     => $request->priority,
          'status'       => $request->status,
        );

        //$category = DB::table('categories')->where('id',$request->hidden_id)->update($form_data);
        Category::where('id',$request->hidden_id)->update($form_data);
        return response()->json(['success' => 'Data Successfully Updated']);
    }

    public function destroy($id)
    {
      $data = Category::findOrFail($id);
        $data->delete();
    }
}
