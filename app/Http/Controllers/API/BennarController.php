<?php

namespace App\Http\Controllers\API;

use App\Bennar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class BennarController extends Controller
{

    private $Image_Path;

    public function __construct()
    {
        $this->Image_Path = public_path('admin_asset/Benner');
    }
    public function index()
    {
        $Benner = Bennar::with('getCategory')->get();
        if((bool)$Benner){
            return response()->json(['status'=>1,'data'=>$Benner]);
        }else{
            return response()->json(['status'=>0,'error'=>['error_code'=>404,'error_massage'=>'Data Not Found']]);
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $Validat = Validator::make($request->all(),[
            'bennar'=>'required|mimes:jpeg,jpg,png,gif|max:10000',
            'description'=>'max:50',
        ]);
        if($Validat->fails()){
            return response()->json([
                    'status'=>0,
                    'error'=>[
                        'error_code'=>422,
                        'error_massage'=>$Validat->messages()->first()
                    ],
            ]);
        }

        if (!is_dir($this->Image_Path)) {
            mkdir($this->Image_Path, 0777);
        }
        if($request->hasFile('bannar')){
            $photo = $request->file('bannar');
            $ext = $photo->getClientOriginalExtension();
            $name = sha1(date('YmdHis') . str_random(30));
            $file_name = $name . '.' . $photo->getClientOriginalExtension();
            $photo->move($this->Image_Path, $file_name);
            $request->request->add(['path' =>$file_name]);
        }
        $addBannar = Bennar::Create($request->all());

        if((bool)$addBannar){
            return response()->json(['status'=>1,'data'=>$addBannar]);
        }else{
            return response()->json(['status'=>0,'error'=>['error_code'=>422,'error_massage'=>'Invalid Data']]);
        }

    }

    public function show($bennar)
    {

        $Benner = Bennar::with('getCategory')->find($bennar);
        if((bool)$Benner){
            return response()->json(['status'=>1,'data'=>$Benner]);
        }else{
            return response()->json(['status'=>0,'error'=>['error_code'=>404,'error_massage'=>'Data Not Found']]);
        }
    }

    public function edit(Bennar $bennar)
    {
        //
    }

    public function update(Request $request,$bennar)
    {
        $Benner = Bennar::find($bennar);
        if((bool)$Benner){
            $Validat = Validator::make($request->all(),[
                'bennar'=>'mimes:jpeg,jpg,png,gif|max:10000',
                'description'=>'max:50',
            ]);
            if($Validat->fails()){
                return response()->json([
                        'status'=>0,
                        'error'=>[
                            'error_code'=>422,
                            'error_massage'=>$Validat->messages()->first()
                        ],
                ]);
            }
            if($request->bennarstatus == 1){
                if (!is_dir($this->Image_Path)) {
                    mkdir($this->Image_Path, 0777);
                }
                if($request->hasFile('bannar')){
                    $photo = $request->file('bannar');
                    $ext = $photo->getClientOriginalExtension();
                    $name = sha1(date('YmdHis') . str_random(30));
                    $file_name = $name . '.' . $photo->getClientOriginalExtension();
                    $photo->move($this->Image_Path, $file_name);
                    $request->request->add(['path' =>$file_name]);
                }

                $editBennar = Bennar::where('id',$bennar)->update($request->only(['path','description','categories_id']));
            }else{
                $editBennar = Bennar::where('id',$bennar)->update($request->only(['description','categories_id']));
            }

            if((bool)$editBennar){
                return response()->json(['status'=>1,'data'=>$editBennar]);
            }else{
                return response()->json(['status'=>0,'error'=>['error_code'=>422,'error_massage'=>'Invalid Data']]);
            }

        }else{
            return response()->json(['status'=>0,'error'=>['error_code'=>404,'error_massage'=>'Data Not Found']]);
        }

    }

    public function destroy(Bennar $bennar)
    {
        unlink($this->Image_Path.'/'.$bennar->path);
        $removebennar = $bennar->delete();
        if((bool)$removebennar){
            return response()->json(['status'=>1,'data'=>$removebennar]);
        }else{
            return response()->json(['status'=>0,'error'=>['error_code'=>404,'error_massage'=>'Data Not Found']]);
        }
    }
}
