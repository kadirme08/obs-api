<?php

namespace App\Http\Controllers\API\admin\API\ogrenciAuth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StudentAuthController extends Controller
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
                'Utype'=>'1'
            ]);
            $user->syncRoles('ogrenci');
            $token=$user->createToken("APİ TOKEN")->plainTextToken;

            return response()->json([
                'status'=>true,
                'succsess'=>'kullanıcı başarı ile oluşturuldu',
                'token'=>$token
            ],200);
        }catch (\Throwable $e){
            return response()->json([
                'status'=>false,
                'message'=>$e->getMessage(),
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
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'Utype' => 1])) {
                $user=User::where('email',$request->email)->first();
                    $token=$user->createToken("APİ TOKEN")->plainTextToken;
                return response()->json([
                    'status'=>true,
                    'user'=>$user,
                    'token'=>$token
                ],200);
            }else{
                return response()->json([
                    'status'=>false,
                    'message'=>'kullanıcı adı Yada Şifreniz yanlış'
                ]);
            }
        }catch (\Throwable $e){
            return response()->json([
                'status'=>false,
                'message'=>$e->getMessage(),
            ],400);
        }
    }
    public function logout(Request $request){
       $request->user()->tokens->delete();
       return send_ms('User Logout başarılı','true',200);
    }
}
