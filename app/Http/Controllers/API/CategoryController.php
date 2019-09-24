<?php

namespace App\Http\Controllers\API;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class CategoryController extends Controller
{

    public function index()
    {
        $category = Category::all();
        if((bool)$category){
            return response()->json(['status'=>1,'data'=>$category]);
        }else{
            return response()->json(['status'=>0,'error'=>['error_code'=>404,'error_massage'=>'Data Not Found']]);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required|max:50',
        ]);
        if($validator->fails()){
            return response()->json([
                    'status'=>0,
                    'error'=>[
                        'error_code'=>422,
                        'error_massage'=>$validator->messages()->first()
                    ],
            ]);
        }
        $category = Category::create($request->all());

        if((bool)$category){
            return response()->json(['status'=>1,'data'=>$category]);
        }else{
            return response()->json(['status'=>0,'error'=>['error_code'=>422,'error_massage'=>'Invalid Data']]);
        }
    }

    public function show($category)
    {
        $singleCategory = Category::findOrFail($category);
        if((bool)$singleCategory){
            return response()->json(['status'=>1,'data'=>$singleCategory]);
        }else{
            return response()->json(['status'=>0,'error'=>['error_code'=>404,'error_massage'=>'Data Not Found']]);
        }
    }

    public function update(Request $request,$Category)
    {

        $validator = Validator::make($request->all(),[
            'name'=>'required|max:50',
        ]);
        if($validator->fails()){
            return response()->json(['status'=>0,'error'=>['error_code'=>422,'error_massage'=>$validator->messages()->first()],]);
        }
        $singleCategory = Category::findOrFail($Category)->first();

        if((bool)$singleCategory){
            $updatedata=Category::where('id',$Category)->update($request->only(['name','parent']));
            if((bool)$updatedata){
                return response()->json(['status'=>1,'data'=>$updatedata]);
            }else{
                return response()->json(['status'=>0,'error'=>['error_code'=>422,'error_massage'=>'Invalid Data']]);
            }
        }else{
            return response()->json(['status'=>0,'error'=>['error_code'=>404,'error_massage'=>'Data Not Found']]);
        }
    }

    public function destroy(Category $Category)
    {
        $removeCategory = $Category->Delete();
        if((bool)$removeCategory){
            return response()->json(['status'=>1,'data'=>$removeCategory]);
        }else{
            return response()->json(['status'=>0,'error'=>['error_code'=>422,'error_massage'=>'Invalid Data']]);
        }
    }
}
