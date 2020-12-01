<?php

namespace App\Http\Controllers;


class BaseController extends Controller
{
   
    public function sendRespone($result,$message){


        $respone=[
            'success'=>true,
              'data'=>$result,
              'message'=>$message
        ];

        return response()->json($respone,200);
    }

    public function sendError($error,$errormessage=[]){


        $respone=[
            'success'=>true,
              'message'=>$error
        ];

        if(!empty($errormessage)){

            $respone['data']=$errormessage;
        }
        return response()->json($respone,404);


}
}