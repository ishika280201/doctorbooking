<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    public function index(Request $request){
        if($request->ajax()){
            $data= User::where('user_type','=','Doctor');
             
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
        return view('backend.doctor.list');
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(),[
            'profile_image'  => 'required',
            'name'   => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'dob'        => 'required',
            'gender'  => 'required',
            'speciality'    => 'required',
            'qualification'    => 'required',
            'address'    => 'required',
          //'status'   => 'required'
            'user_type'   => 'Doctor',
        ]);
        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $doctorImage = $request->file('profile_image');
        $doctorImageName = rand() . '.' . $doctorImage->getClientOriginalExtension();
        $doctorImage->move(public_path('img/doctors'), $doctorImageName);
        
         $doctordata = new User;
         $doctordata->id = $request->id;
         $doctordata->profile_image = $doctorImageName; 
         $doctordata->name = $request->name;
         $doctordata->email = $request->email;
         $doctordata->phone_number = $request->phone_number;
         $doctordata->dob = $request->dob;
         $doctordata->gender = $request->gender;
         $doctordata->qualification = $request->qualification;
         $doctordata->speciality = $request->speciality;
         $doctordata->address = $request->address;
         $doctordata->status = $request->status;
         $doctordata->password = '123456889';
         $doctordata->user_type = 'Doctor';
         $doctordata->save();

        return response()->json(['success'=>'Data Added Successfully']); 
      }
    
      public function edit($id){
        if(request()->ajax()){
          $data = User::findOrFail($id);
          return response()->json(['result'=>$data]);
          
        }
      }

      public function update(Request $request, User $user){
        $rules = array(
            'profile_image'  => 'required',
            'name'   => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'dob'     => 'required',
            'gender'   =>  'required',
            'address'  => 'required',
            'speciality'    => 'required',
            'qualification'    => 'required',
             //'status'   => 'required'
            'user_type'   => 'Doctor',
        );

        $validator  = Validator::make($request->all(), $rules);
        if($validator->fails()){
          return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $user  = User::find($request->id);
        $user-> name = $request->name;     
        $user-> email = $request->email;        
        $user-> phone_number = $request->phone_number;     
        $user-> dob = $request->dob;     
        $user-> gender = $request->gender;        
        $user-> speciality = $request->speciality;        
        $user-> qualification = $request->qualification;  
        $user-> address = $request->address;  
        $user-> status = $request->status;  
        $user->password = '123456889';
        $user->user_type = 'Doctor';
        $user->save();          
      
        if($request->profile_image != 'undefined'){
        if($request->hasFile('profile_image')){
        $file = $request->file('profile_image');
        $destinationPath = public_path(). '/img/doctors';
        $filename = $file->getClientOriginalName();
        $file->move($destinationPath, $filename);

        //then proceeded to save user
        $user-> profile_image = $filename;

        $user->save();
        }
    }else{
     
    }

        User::where('id',$request->hidden_id2);
        return response()->json(['success' => 'Data Successfully Updated']);
  
  }

    public function destroy($id)
    {
      $data = User::findOrFail($id);
        $data->delete();
    }
}
