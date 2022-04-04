<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsVerify extends Model
{
    use HasFactory;

    protected $table = "smsverify";
     protected $fillable = [
         'phone_number',
         'code',
         'status',
     ];

     public function user(){
         return $this->belongsTo('App\Models\User','user_id');
     }
}
