<?php

namespace App\Http\Controllers\API;

use App\CompanyInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;


class CompanyInfoController extends Controller
{   
    private $photos_path;

    public function __construct()
    {
        $this->photos_path = public_path('admin_asset/logo/');
    }
    public function index()
    {
         $data=CompanyInfo::find(1);

         if((bool)$data){
            return response()->json([
                    'status'=>1,
                    'data'=>$data
                 ]);
         }else{

            return response()->json([
                    'status'=>0,
                    'error'=>['error_code'=>201]
                 ]);

         }
    }
   
    public function create()
    {
        
    }

   
    public function store(Request $request)
    {
        //
    }

   
    public function show(CompanyInfo $companyInfo)
    {
        //
    }

    
    public function edit(CompanyInfo $companyInfo)
    {
        
    }

    
    public function update(Request $request, CompanyInfo $companyInfo)
    {   

        $Validator=Validator::make($request->all(),[

            'name'=> 'required',
            'address'=> 'required',
            'logostatus'=> 'required'

        ]);

        if ($Validator->fails()) { 
                        return response()->json(['status'=>0,'error'=>$Validator->errors()], 401);            
                    }

        if($request->logostatus==1){
             if (!is_dir($this->photos_path)) {
                mkdir($this->photos_path, 0777);
             }
                
             $photo = $request->file('logoimage');
             $ext = $photo->getClientOriginalExtension();
             $name = sha1(date('YmdHis') . str_random(30));
             $file_name = $name . '.' . $photo->getClientOriginalExtension();
             $photo->move($this->photos_path, $file_name);
             
             $request->request->add(['logo' =>$file_name]);
            
              $data=$companyInfo->update($request->only(['name','logo','address','mobile','email','workingtime']));
         }else{
             $data=$companyInfo->update($request->only(['name','address','mobile','email','workingtime']));
         }

        

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

    
    public function destroy(CompanyInfo $companyInfo)
    {
        //
    }
}
