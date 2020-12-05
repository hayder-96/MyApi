<?php

namespace App\Http\Controllers;

use App\Models\Coordinate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\coordinate as coor;
class CoordinateController extends BaseController
{
    public function index()
    {
        $post=Coordinate::all();

        return $this->sendRespone(coor::collection($post),'Done get');
    }

    public function userpost($id)
    {
        $post=Coordinate::where('user_id',$id)->get();

        return $this->sendRespone($post,'Done get');
    }







    public function store(Request $request)
    {

        $input=$request->all();

        $validit=Validator::make($request->all(),[

            'name'=>'required',
            'latitude'=>'required',
            'logitude'=>'required'
        ]);
        if($validit->fails()){

            return $this->sendError('failed register!',$validit->errors());
        }
        $user=Auth::user();
        $input['user_id']=$user->id;
        $post=Coordinate::create($input);

        return $this->sendRespone($post,'successfully input');


    }

   
    public function show($id)
    {
        $post=Coordinate::find($id);
        if($post==null){
            return $this->sendError('failed show');
        }
        return $this->sendRespone(new coor($post),'successfully show');
    }

    
    public function update(Request $request,Coordinate $post)
    {
        
        $input=$request->all();

        $validit=Validator::make($request->all(),[

            'name'=>'required',
            'latitude'=>'required',
            'logitude'=>'required'
        ]);
        if($validit->fails()){

            return $this->sendError('failed update',$validit->errors());
        }
        if($post->user_id!=Auth::id()){
            return $this->sendError('can not update',$validit->errors());
        }
        $post->name=$input['name'];
        $post->latitude=$input['latitude'];
        $post->logitude=$input['logitude'];
        $post->save();
        return $this->sendRespone(new coor($post),'successfully update');
    }



    public function destroy(Coordinate $post)
    {
        if($post->user_id!=Auth::id()){
            return $this->sendError('can not deleted');
        }
        $post->delete();
        return $this->sendRespone(new coor($post),'successfully delete');
    }

}
