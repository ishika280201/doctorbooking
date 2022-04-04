<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\App;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function lang($locale){
        App::setlocale($locale);
        session()->put('locale', $locale);
        return redirect()->back();    
    }

    public function ajaxValidationError($result = [], $message = null, $status= '422'){
        $response = [
            'success' => "1",
            'status'  => $status,
            'message' => $message,
            'data'    => [],
            'error'   => $result,
        ];
        echo json_encode($response); exit;
    }

    public function ajaxError($result = [], $message = null, $status = '201'){
        $response = [
            'success'  => "0",
            'status'   => $status,
            'message'  => $message,
            'data'     => [], 
        ];
        echo json_encode($response); exit;
    }

    public function sendResponse($result = [], $message = null, $status= '200'){
        $response = [
            'success'   => "1",
            'status'    => $status,
            'message'   => $message,
            'data'      => [],
        ];
        if(!empty($result)){
            $response['data'] = $result;
        }
        echo json_encode($response); exit;
    }

    public function sendArrayResponse($result = [], $message = null, $status = '200'){
        $response = [
            'success'  => "1",
            'status'   => $status,
            'message'  => $message,
            'data'     => [], 
        ];
        if(!empty($result)){
            $response['data'] = $result;
        }
        echo json_encode($response); exit;
    }

    public function sendError($result = [], $message, $code = 200, $status = '201'){
        $response = [
            'success' => "0",
            'status'  => $status,
            'message' => $message,
            'data'    => new \stdClass(),
        ];
        if(!empty($result)){
            $response['data'] = $result;
        }

        return response()->json($response, $code);
    }

    public function sendValidationError($result = [],$message, $code = 200, $status = '201'){
        $response = [
            'success'   => "0",
            'status'    => $status,
            'message'   => $message,
            'data'      => new \stdClass(),
        ];
        if(!empty($result)){
            $response['data'] = $result;
        }

        return response()->json($response, $code);
    }

    public function sendException($result = [], $message, $status = '201'){
        $response = [
            'success'   => "1",
            'status'    => $status,
            'message'   => $message,
            'data'      => new \stdClass(),
        ];
        if(!empty($result)){
            $response['data'] = $result;
        }
        return response()->json($response, 200);
    }

    public function sendUnauthorizedError($result = [], $message = null, $code = 200, $status = '401'){
        $response = [
            'success'      => "0",
            'status'       => $status,
            'message'      => $message,
            'data'         => new \stdClass(),
        ];
        return response()->json($response, $code);
    }
}
