<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceDetails extends Model
{
    use HasFactory;

    protected $table = "devicedetails";

    protected $fillable = [
        'user_id',
        'token',
        'device_token',
        'device_type',
        'uuid',
        'ip',
        'os_version',
        'model_name',
    ];

    public function user(){
        return $this->belongsTo('App\Models\User','id');
    }
}
