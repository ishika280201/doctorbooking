<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Appointments;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class AppointmentController extends Controller
{
    public function index(Request $request){
        if($request->ajax()){
            $data = Appointments::select('*');
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn1 = '<a href="javascript:void(0)" id="'.$row->id.'"  class="edit btn btn-primary btn-sm">Edit</a>';
                return $btn1;
            })
            //->rawColumns(['action'])
            // ->addIndexColumn()
            ->addColumn('status', function($row)  {
				return '<select id="select" name"select">
                              <option>Accept</option>
                              <option>Pending</option>
                              <option>Cancelled</option>
                        </select> ';
		})
        ->rawColumns(['status','action'])
            ->make(true);
        }
        return view('backend.appointment.list');
    }
}
