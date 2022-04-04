<?php

namespace App\Models\Helpers;

use Illuminate\Support\Facades\Storage;
use App\Models\SmsVerify;
use Exception;
use Illuminate\Support\Facades\DB;

trait CommonHelper{

    // public variables

    public $media_path = 'uploads/';

    public function get_upload_directory($folder = ''){
        $year = date("y");
        $month = date("m");
        $folder = $folder ? $folder . '/' : '';

        $media_path1 = public_path($this->media_path . $folder . $year.'/');
        $media_path2 = public_path($this->media_path . $folder . $year.'/'. $month.'/');
        $media_path3 = $this->media_path . $folder . $year . '/'. $month.'/';

        if(!is_dir($media_path1)){
            mkdir($media_path1, 0755, true);
        }

        if(!is_dir($media_path2)){
            mkdir($media_path2, 0755, true);
        }
        return $media_path3;
    }

    public function saveMedia($file, $folder = '', $type = '', $width = '', $height = ''){
        if(empty($file)){
            return;
        }
        $upload_directory        = $this->get->get_upload_directory($folder);
        $name                    = md5($file->getClientOriginalName() . time() . rand());
        $extension               = $file->guessExtension();
        $fullname                = $name . '.' . $extension;
        $thumbnail               = $name .'150X150.'. $extension; 

        if($type == ''){
            $file->move(public_path($upload_directory), $fullname);
            return $upload_directory . $fullname;
        }elseif($type == 'image'){
            DB::beginTransaction();
            try{
                $path = Storage::disk('s3')->put('images/originals', $file,'public');
                DB::commit();
                return $path;
            }catch(\Exception $e){
                DB::rollBack();
                $path = '-';
                return $path;
            }
        }else{
            return false;
        }
    }

    public static function validatephone($country_code = '+91', $phone_number = ""){
        if(empty($country_code)){ return; }
        if(empty($phone_number)){ return; }

        $number = str_replace(' ', '', $phone_number);
        $first_number = substr($number, 0, 1);
        if($first_number == 0){
            $number = substr($number, 1, 999);
        }
        return $result = preg_replace("/^\+?{$country_code}/", '',$number);
    }

    public static function sendOTP($user, $otp=''){
        if(empty($user)){ return; }
        if(empty($otp)){ return; }
        
        DB::beginTransaction();
        try{
            $message = 'Hello'. $user->name .', Use '. $otp .' for OTP on '. config('constants.APP_NAME');
            $query = SmsVerify::create(['phone_number' => $user->phone_number, 'code' => $otp]);
            if($query){
                $return = CommonHelper::sendSMS($user->country_code. $user->phone_number, $message);
            }
            if($return){
                DB::commit();
                return $return;
            }
        }catch(Exception $e){
            DB::rollBack();
            return;
        }
    }

    public static function sendMessage($to, $message = ""){
        
        //send sms
        return CommonHelper::sendSMS($to, $message);

        //send whatsapp
        return CommonHelper::sendWhatsApp($to, $message);
    }

    public static function sendSMS($to, $message= ""){
        if(empty($to)){ return; }
        if(empty($message)){ return; }

        try{
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://console.twilio.com/?frameUrl=%2Fconsole%3Fx-target-region%3Dus1". config('constants.SMS_USERNAME') ."&message=". urlencode($message) ."&sendername=". config('constants.SMS_SENDER') ."&smstype=TRANS&numbers=$to&apikey=". config('constants.SMS_TOKEN'));
            curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            return $response;
            
        }catch(Exception $e){
            return false;
        }    
    }


}
