<?php

namespace App\Http\Controllers;

use App\Models\post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\post as repost;
use Illuminate\Support\Facades\Auth;

class PostController extends  BaseController
{
    public function index()
    {
        $post=post::all();

        return $this->sendRespone(repost::collection($post),'Done get');
    }

    public function userpost($id)
    {
        $post=post::where('user_id',$id)->get();

        return $this->sendRespone($post,'Done get');
    }







    public function store(Request $request)
    {

        $input=$request->all();

        $validit=Validator::make($request->all(),[

            'title'=>'required',
            'description'=>'required'
        ]);
        if($validit->fails()){

            return $this->sendError('failed register!',$validit->errors());
        }
        $user=Auth::user();
        $input['user_id']=$user->id;
        $post=post::create($input);

        return $this->sendRespone($post,'successfully input');


    }

   
    public function show($id)
    {
        $post=post::find($id);
        if($post==null){
            return $this->sendError('failed show');
        }
        return $this->sendRespone(new repost($post),'successfully show');
    }

    
    public function update(Request $request,post $post)
    {
        
        $input=$request->all();

        $validit=Validator::make($request->all(),[

            'title'=>'required',
            'description'=>'required'
        ]);
        if($validit->fails()){

            return $this->sendError('failed update',$validit->errors());
        }
        if($post->user_id!=Auth::id()){
            return $this->sendError('can not update',$validit->errors());
        }
        $post->title=$input['title'];
        $post->description=$input['description'];
        $post->save();
        return $this->sendRespone(new repost($post),'successfully update');
    }



    public function destroy(post $post)
    {
        if($post->user_id!=Auth::id()){
            return $this->sendError('can not deleted');
        }
        $post->delete();
        return $this->sendRespone(new repost($post),'successfully delete');
    }
}
