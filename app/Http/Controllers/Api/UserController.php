<?php

namespace App\Http\Controllers\Api;

use App\Models\Helpers\CommonHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use CommonHelper;
    
    public function profile(Request $request){
        DB::beginTransaction();
        try{
            $user_id = Auth::user()->id;
            if(empty($user_id)){
                return $this->sendError('', trans('customer_api.invalid_user'));
            }

            $user = User::where('id', $user_id)->first();
            return $this->sendResponse(new UserResource($user), trans('customer_api.data_found_success'));
        }catch(\Exception $e){
            return $this->sendError('', trans('customer_api.data_found_empty'));
        }
   }

       public function update(Request $request){
       $validator = Validator::make($request->all(), [
            'name'                => 'required|string|min:3|max:99',
            'email'               => 'required|string|email',
            'country_code'        => 'required|min:2|max:4',
            'phone_number'        => 'required|min:10|max:10',
            'gender'              => 'required',
            'dob'                 => 'required',
       ]);

       if($validator->fails()){
           return $this->sendValidationError('',$validator->errors()->first());
       }
       $user = Auth::user();
       if(empty($user)){
           return $this->sendError('', trans('customer_api.invalid_user'));
       }

       if(!filter_var($request->email, FILTER_VALIDATE_EMAIL)){
           return $this->sendError('', trans('customer_api.invalid_email'));
       }

       $email = User::where('email', $request->email)->whereNotIn('id', [$user->id])->first();
       if(!empty($email)){
           return $this->sendError('', trans('customer_api.email_already_exist'));
       }

       $phone_number = User::where('phone_number', $request->phone_number)->whereNotIn('id', [$user->id])->first();
       if(!empty($phone_number)){
           return $this->sendError('', trans('customer_api.phone_number_already_exist'));
       }

       DB::beginTransaction();
       try{
           $query = User::where('id', $user->id)->update([
                'name'               => $request->name,
                'email'              => $request->email,
                'country_code'       => $request->country_code,
                'phone_number'       => $request->phone_number,
                'gender'             => $request->gender,
                'dob'                => date('d-m-y', strtotime($request->dob)), 
           ]);

           if($query){
               DB::commit();

               $user = User::where('id', $user->id)->first();

               $success['id']                   = (string)$user->id;
               $success['name']                 = $user->name;
               $success['email']                = $user->email;
               $success['country_code']         = $user->country_code;
               $success['phone_number']         = $user->phone_number;
               $success['gender']               = $user->gender;
               $success['dob']                  = $user->dob;
               $success['status']               = $user->status;

               return $this->sendResponse($success, trans('customer_api.profile_update_success'));
           }else{
               DB::rollBack();
               return $this->sendError('', trans('customer_api.profile_update_error'));
           }
       }catch(\Exception $e){
           DB::rollBack();
           return $this->sendError('', trans('customer_api.profile_update_error'));
       }
   }

   public function save_favourite(Request $request){
       $validator = Validator::make($request->all(),[
            'favourite_id'   => 'required|integer',
       ]);
       
       if($validator->fails()){
           return response()->json(['errors'=>$validator->errors()->all()]);
       }
      
       $user = Auth::user();

       $query =  Product::where('id',$request->favourite_id)->first();

       if($query){
           $item = Wishlist::where('user_id',$user->id)
           ->where('product_id',$query->id)->first();

            if($item){
                $item->save();
            }else{
                $insert =[
                    'product_id' =>  $request->favourite_id,
                     'title'     => $query->title,
                     'date'       => date('Y-m-d'),
                    ];
        
                    $insert['token']  = csrf_token();
                    $insert['user_id'] =  $user->id;
        
                Wishlist::create($insert);
            }

            $wishlist = Wishlist::select('product_id','user_id','token','title','date')->where('user_id',$user->id)->get();
           if($wishlist){
               return response()->json([
                   'success'=>'Product added to favourites',
                   'result'=>$wishlist,
            ]);
           }
       }
   }

   public function favourite_doctor(Request $request){
        $validator = Validator::make($request->all(),[
            'doctorid' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        $user = Auth::user();
        $result =  User::where('id',$request->doctorid)->first();

        if($result){
            $favourite = Wishlist::where('user_id',$user->id)
            ->where('doctor_id',$result->id)->first();
 
             if($favourite){
                 $favourite->save();
             }else{
                 $doctordata =[
                     'doctor_id' =>  $request->doctorid,
                     'title'     => $result->name,
                      'speciality'     => $result->speciality,
                      'date'       => date('Y-m-d'),
                     ];
         
                     $doctordata['token']  = csrf_token();
                     $doctordata['user_id'] =  $user->id;
         
                 Wishlist::create($doctordata);
             }
 
             $wishlists = Wishlist::select('user_id','token','date','doctor_id','speciality','title')->where('user_id',$user->id)->get();
            if($wishlists){
                return response()->json([
                    'success'=>'Doctor added to favourites',
                    'result'=>$wishlists,
             ]);
            }
        }
   }

   public function favourite_list(Request $request){
    $user = Auth::user();
    $getlist = Wishlist::select('id','doctor_id','token','title','speciality')
    ->get();
    
    if($getlist){
     return response()->json(['result'=>$getlist]);
    }
}

    public function delete_favourite(Request $request){
        $validator = Validator::make($request->all(),[
            'delete_id'   => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

         $delete = Wishlist::where('id',$request->delete_id)->delete();
         
         if($delete){
            return response()->json([
                'success'=>'Deleted Favourites',
         ]);
         }
    }

}
