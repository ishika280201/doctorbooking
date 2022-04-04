<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DeviceDetails;
use App\Models\User;
use App\Models\Helpers\CommonHelper;
use App\Models\SmsVerify;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginOtpController extends Controller
{
    //login user

    public function login(Request $request){
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->plainTextToken; 
            $success['name'] =  $user->name;
            $success['email']           = $user->email;
            $success['password']        = $user->password;
            $success['country_code']    = $user->country_code;
            $success['phone_number']    = $user->phone_number;
            $success['status']          = 'pending';
            $success['gender']          = $user->gender;
            $success['dob']             = $user->dob;
            $success['user_type']       = 'Customer';
   
            return $this->sendResponse($success, 'User login successfully.');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }

    // register user data
    
    public function register(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:99',
            'email' => 'required|email',
            'password' => 'required|min:8|max:15',
            'country_code'  => 'required|min:2|max:4',
            'phone_number'  => 'required|min:8|max:10',
        //    'gender'        => 'required',
            'dob'           => 'required',
           
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;
        $success['email']           = $user->email;
        $success['password']        = $user->password;
        $success['country_code']    = $user->country_code;
        $success['phone_number']    = $user->phone_number;
        $success['status']          = 'pending';
        //$success['gender']          = $user->gender;
        $success['dob']             = $user->dob;
        $success['user_type']       = 'Customer';
   
        return $this->sendResponse($success, 'User register successfully.');

          }

    // send otp

    public function sendOTP(Request $request){
        $validator = Validator::make($request->all(),[
            'phone_number' =>  'required|min:10|max:10',
            'country_code' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendValidationError('',$validator->errors()->first());
        }

        DB::beginTransaction();
        try{
            $user = User::where(['phone_number' => $request->phone_number])->first();
            if(empty($user)){
                return $this->sendError('', trans('customer_api.no_account_user'));
            }

            $sent = CommonHelper::sendOTP($user, rand(100000,999999));
            if($sent){
                DB::commit();
                return $this->sendResponse("", trans('customer_api.otp_sent_success'));
            }

            return $this->sendError('', trans('customer_api.try_again'));
        }catch(\Exception $e){
            DB::rollBack();
            return $this->sendError('', $e->getMessage());
        }
    }

    // verify otp

    public function verifyOTP(Request $request){
        $validator = Validator::make($request->all(), [
            'otp'                => 'required|min:4|max:6',
            'country_code'       => 'required|min:2|max:4',
            'phone_number'       => 'required|min:10|max:10',
        ]);

        if($validator->fails()){
            return $this->sendValidationError('', $validator->errors()->first());
        }

        DB::beginTransaction();
        try{
            $status = SmsVerify::where(array('phone_number'=>$request->phone_number, 'code'=>$request->otp, 'status'=>'pending'))->first();
            if(empty($status)){
                return $this->sendError('', trans('customer_api.invalid_otp'));
            }
            
            $status->status = 'verified';
            $status->update();
            DB::commit();
            return $this->sendResponse("", trans('customer_api.otp_verified_success'));       
    }catch(\Exception $e){
        DB::rollBack();
        return $this->sendError('', trans('customer_api.otp_verified_success'));
    }
}

    //active account 

    public function active(Request $request){
        $validator = Validator::make($request->all(), [
            'otp'            => 'required|min:4|max:6',
            'country_code'    => 'required|min:2|max:4',
            'phone_number'    => 'required|min:10|max:10',
        ]);
        
        if($validator->fails()){
            return $this->sendValidationError('', $validator->errors()->first());
        }

        $user = User::where(array('phone_number'=>$request->phone_number))->first();
        if(empty($user)){
            return $this->sendError('', trans('customer_api.invalid_user'));
        }

        if($user->status == 'active'){
            return $this->sendError('', trans('customer_api.already_activated'));
        }
        DB::beginTransaction();
        try{
            $dataArray = $request->all();
            $result = SmsVerify::where(array('phone_number'=>$request->phone_number,'code'=>$request->otp, 'status'=>'pending'))->first();
            if(empty($result)){
                return $this->sendError('', trans('customer_api.invalid_otp'));
            }
            $result->status = 'verified';
            $result->update();

            $user->status = 'active';
            $user->update();
            DB::commit();

                $success['token']           = $user->createToken(config('app.name'))->accessToken;
                $success['id']              = (string)$user->id;
                $success['name']            = $user->name;
                $success['email']           = $user->email;
                $success['password']        = $user->password;
                $success['country_code']    = $user->country_code;
                $success['phone_number']    = $user->phone_number;
                $success['status']          = 'active';
                $success['gender']          = $user->gender;
                $success['dob']             = $user->dob;
                $success['user_type']          = $user->user_type;
 
                return $this->sendResponse($success, trans('customer_api.account_act_success'));
        }catch(\Exception $e){
            DB::rollBack();
            return $this->sendError('', trans('customer_api.account_act_error'));
        }
    }

    //login with otp

    public function loginwithotp(Request $request){
        $validator = Validator::make($request->all(),[
            'username'    => 'required|min:8|max:51',
            'otp'         => 'required|min:4|max:6',    
        ]);
        if($validator->fails()){
            return $this->sendValidationError('',$validator->errors()->first());
        }

        DB::beginTransaction();
        try{
            $user = User::where('phone_number',$request->username)->where('status','!=','blocked')->first();
            
            if($user){
                $user_details = SmsVerify::where(['phone_number'=>$request->username,'code'=>$request->otp])->where('status','pending')->first();
                if($user_details){
              /*      $otp_generated_date = new DateTime($user_details->created_at);
                    $now_date = new DateTime(Carbon::now('Asia/Kolkata'));
                    $interval = $otp_generated_date->diff($now_date);
                    $eclaps_minute = $interval->format('%i');
                    if($eclaps_minute > 5){
                        return $this->sendError("", 'Request Time Out', "408");
                    }*/
                    
                    $user_details->status = 'verified';
                    $user_details->update();

                    DB::table('oauth_access_tokens')->where('user_id',$user->id)->update(['revoked'=>true]);
                    
                    $success['token']           = $user->createToken(config('app.name'))->accessToken;
                    $success['id']              = (string)$user->id;
                    $success['name']            = $user->name;
                    $success['email']           = $user->email;
                    $success['password']        = $user->password;
                    $success['country_code']    = $user->country_code;
                    $success['phone_number']    = $user->phone_number;
                    $success['status']          = $user->status;
                    $success['gender']          = $user->gender;
                    $success['dob']             = $user->dob;
                    $success['user_type']          = $user->user_type;

                    return $this->sendResponse($success, trans('customer_api.login_success'));
                }else{
                    return $this->sendError('','OTP not matched');
                }
            }else{
                return $this->sendError('','This user is not registered');
            }
        }catch(\Exception $e){
            DB::rollBack();
            return $this->sendError('',$e->getMessage());
        }
    }
        //delete account

        public function deleteaccount(Request $request){
            $user = Auth::user();
            if(empty($user)){
                return $this->sendError('', trans('customer_api.unauthorized_access'));
            }
            DB::beginTransaction();
            try{
                $query = User::where('id',$user->id)->delete();
                if($query){
                    DB::commit();
                    return $this->sendResponse('', trans('customer_api.profile_deleted'));
                }
                return $this->sendError('', trans('customer_api.failed_to_delete_account'));
            }catch(\Exception $e){
                DB::rollBack();
                return $this->sendError([], $e->getMessage());
            }
        }
        
    //logout user

    public function logout(Request $request){
        if ($request->user()) { 
            $request->user()->tokens()->delete();
        }
        return $this->sendResponse('', trans('customer_api.logout'));
    }
}
