<?php

namespace App\Http\Controllers\API;

use App\SocialMedia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SocialMediaController extends Controller
{

    public function index()
    {
        $data=SocialMedia::all();
        
        return response()->json([
            'status'=>1,
            'data'=>$data
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {

        $Validator=Validator::make($request->all(),[

            'media'=> 'required',
            'link'=> 'required',

        ]);

        if ($Validator->fails()) { 
            return response()->json(['status'=>0,'error'=>$Validator->errors()], 401);            
        }


        $data=SocialMedia::create($request->all());

        if((bool)$data){
            return response()->json([
                    'status'=>1,
                    'data'=>$data
            ]);
        }else{
            return response()->json([
                    'status'=>0,
                     'error'=>['error_code'=>204]
                ]);
        }
    }

    
    public function show($socialMedia)
    {
        $data=SocialMedia::find($socialMedia);

        if((bool)$data){
            return response()->json([
                    'status'=>1,
                    'data'=>$data
            ]);
        }else{
            return response()->json([
                'status'=>0,
                'error'=>["error_code"=>204]
            ]);
        }

    }

    public function edit(SocialMedia $socialMedia)
    {
         $data=$socialMedia;
        if((bool)$data){
            return response()->json([
                    'status'=>1,
                    'data'=>$data
            ]);
        }else{
            return response()->json([
                'status'=>0,
                'error'=>["error_code"=>204]
            ]);
        }         
    }

    public function update(Request $request, SocialMedia $socialMedia)
    {

        $Validator=Validator::make($request->all(),[

            'media'=> 'required',
            'link'=> 'required',

        ]);

        if ($Validator->fails()) { 
            return response()->json(['status'=>0,'error'=>$Validator->errors()], 401);            
        }



        $data=$socialMedia->update($request->only(["media","link"]));
        if((bool)$data){
            return response()->json([
                    'status'=>1,
                    'data'=>$data
            ]);
        }else{
            return response()->json([
                'status'=>0,
                'error'=>["error_code"=>204]
            ]);
        }
    }

    public function destroy(SocialMedia $socialMedia)
    {
          $status=$socialMedia->delete();
         if($status){
            return response()->json([
                    'status'=>1
                   
            ]);
        }else{
            return response()->json([
                'status'=>0,
                'error'=>["error_code"=>204]
            ]);
        }

    }
}
