<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Helpers\CommonHelper;
use App\Models\User;
use App\Models\SmsVerify;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    
        //forgot password

        public function forgot_password(Request $request){
            $validator = Validator::make($request->all(),[
                'username'    => 'required|min:5|max:51',
            ]);

            if($validator->fails()){
                return $this->sendValidationError('',$validator->errors()->first());
            }

            DB::beginTransaction();
            try{
                $user = User::where('email',$request->username)->first();
                if(empty($user)){
                    $user = User::where('phone_number',$request->username)->first();
                }
                if(!empty($user)){
                    $sent = CommonHelper::sendOTP($user, rand(100000,999999));
                    if($sent){
                        DB::commit();
                        return $this->sendResponse("", trans('customer_api.otp_sent_success'));
                    }else{
                        DB::rollBack();
                        return $this->sendError('', trans('customer_api.otp_sent_error'));
                    }
                }
                DB::rollBack();
                return $this->sendError('', trans('customer_api.try_again'));
            }catch(\Exception $e){
                DB::rollBack();
                return $this->sendError('', $e->getMessage());
            }
        }

        public function reset_password(Request $request){
            $validator = Validator::make($request->all(), [
                'username'           => 'required|min:10|max:51',
                'otp'            => 'required|min:4|max:6',
                'country_code'       => 'required|min:2|max:4',
                'password'           => 'required|min:8|max:15',
                'confirm_password'   => 'required|min:8|max:15',
            ]);

            if($validator->fails()){
                return $this->sendValidationError('',$validator->errors()->first());
            }
            $user = User::where('phone_number',$request->username)->first();
            if(empty($user)){
                $user = User::where('email',$request->username)->first();
                return $this->sendError('', trans('customer_api.no_account_user'));
            }

            DB::beginTransaction();
            try{
                $query = User::where('id',$user->id)->update(['password' => Hash::make($request->password)]);
                if($query){
                    DB::commit();
                    return $this->sendResponse('', trans('customer_api.reset_password_success'));
                }
                return $this->sendResponse('', trans('customer_api.reset_password_error'));
            }catch(\Exception $e){
                DB::rollBack();
                return $this->sendError('', $e->getMessage());
            }
        }

        public function change_password(Request $request){
            $validator = Validator::make($request->all(), [
                'password'            => 'required',
                'new_password'        => 'required|min:8|max:15',
                'confirm_password'    => 'required|min:8|max:15|same:new_password',
            ]);
            if($validator->fails()){
                return $this->sendValidationError('',$validator->errors()->first());
            }

            $user = Auth::user();
            if(empty($user)){
                return $this->sendUnauthorizedError('', trans('customer_api.unauthorized_access'));
            }

            DB::beginTransaction();
            try{
                $query = User::where('id', $user->id)->update(['password' => encrypt($request->new_password)]);
                if($query){
                    DB::commit();
                    return $this->sendResponse('', trans('customer_api.password_change_success'));
                }
                DB::rollBack();
                return $this->sendError('', trans('customer_api.password_change_error'));
            }catch(Exception $e){
                DB::rollBack();
                return $this->sendError('', $e->getMessage());
            }
    }
}
