<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request){
        try {
            $validator=Validator::make($request->all(),[
                'name'=>'required',
                'email'=>'required|email|unique:users',
                'password'=>'required',
             ]);

            if ($validator->fails()){

                 return response()->json([
                    'status'=>false,
                    'message'=>$validator->errors()->all(),
                 ],422);
             }
            $user=User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
            ]);
            $token=$user->createToken("APİ TOKEN")->plainTextToken;
            return response()->json([
                'status'=>true,
                'succses'=>'kullanıcı başarı ile oluşturuldu',
                'token'=>$token
            ]);
        }catch (\Throwable $e){
            return response()->json([
                'status'=>false,
                'succses'=>'Kayıt oluşturulurken Bir Hata Oluştu',
            ],400);
        }
    }

  public function login(Request $request){
        try{
            $validator=Validator::make($request->all(),[
               'email'=>'required|email',
               'password'=>'required',
            ]);
            if($validator->fails()){
                return response()->json([
                   'status'=>false,
                   'message'=>$validator->errors()->all()
                ]);
            }
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user=User::where('email',$request->email)->first();
                $token=$user->createToken("APİ TOKEN")->plainTextToken;
                return response()->json([
                 'user'=>$user,
                 'token'=>$token,
                 ],200);
            }else{
                return response()->json([
                 'status'=>false,
                   'message'=>'kullanıcı adı Yada Şifreniz yanlış'
                ],401);
            }
        }catch (\Throwable $e){
            return response()->json([
                'status'=>false,
                'succses'=>'Giriş yaparken Bir Hata Oluştu',
            ],400);
        }
  }
}
