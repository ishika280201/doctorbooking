<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    public function index(Request $request){
        $validator = Validator::make($request->all(),[
            'speciality'   => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $query = User::select('id','profile_image','name','phone_number','email','gender','dob','speciality','qualification','address')
        ->orWhere('speciality', 'like', '%' . $request->speciality . '%')
        ->where('status','active')
        ->where('user_type','Doctor')
        ->first();
        
        if($query){
            return response()->json(['result'=>$query]);
        }else{
            return response()->json(['error'=>'No Data Found']); 
        }
    }

    public function search($id){
        $data = User::select('id','profile_image','name','phone_number','email','gender','dob','speciality','qualification','address')
        ->where('id',$id)
        ->first();

        if($data){
        return response()->json(['result'=>$data]);
        }else{
            return response()->json(['error'=>'No Data Found']); 
        }
    }
}
