<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\BaseController;
class apicontroller extends Controller
{
    public function register(Request $request){

        $resp=new BaseController();

        $validit=Validator::make($request->all(),[

            'name'=>'required',
            'email'=>'required',
            'password'=>'required',
            'c_password'=>'required|same:password',

        ]);
        if($validit->fails()){

            return $resp->sendError('failed register!',$validit->errors());
        }

        $input=$request->all();
        $input['password']=Hash::make($input['password']);
        $user=User::create($input);
        $success['token']=$user->createToken('bvc//<<>>.++--_')->accessToken;
        $success['name']=$user->name;
          
        return $resp->sendRespone($success,'successfully register');

    }

    public function login(Request $request){
        $resp=new BaseController();
        $request->validate([
            'email' => 'required|email', 
            'password' => 'required'
        ]);


       if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){

                 $user=Auth::user();
                 
             $success['token']=$user->createToken('bvc//<<>>.++--_')->accessToken;
            $success['name']=$user->name;
            return $resp->sendRespone($success,'Login Successfuly');
        }
        else{
            return $resp->sendError('error in validtor',['error'=>'Unauthorised']);
        }

    }










}
