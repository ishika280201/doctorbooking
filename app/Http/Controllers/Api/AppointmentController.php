<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Appointments;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function book_appointment(Request $request){
        $validator = Validator::make($request->all(),[
            //'phone_number'       => 'required',
            'doctor_id'          => 'required',
            'appointment_date'   => 'required|date_format:Y-m-d',
            'appointmnet_time'   => 'required|date_format:h:i A'
         ]);

         if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $user = Auth::user();

        $payement_method_id = '1';
        $payement_mode = 'COD';

        $appointment = new Appointments;
        $appointment->id                 = $request->id;
        $appointment->customer_order_id  = '#'.time();
        $appointment->user_id            = $user->id;
        $appointment->name               = $user->name;
        $appointment->phone_number       = $user->phone_number;
        $appointment->doctor_id          = $request->doctor_id;
        $appointment->appointment_date   = $request->appointment_date;
        $appointment->appointmnet_time   = $request->appointmnet_time;
        $appointment->discount           = '0.00';
        $appointment->grand_total        = '100.00';
        $appointment->payement_method_id = $payement_method_id;
        $appointment->payement_mode      = $payement_mode;
        $appointment->order_date         = $request->order_date;
        $appointment->status             = 'Temporary';
        $appointment->save();

        return response()->json(['success'=>'Appointment Created Successfully']); 
    }
}
