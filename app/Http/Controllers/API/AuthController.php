<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        dd($request->all());
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




    }
}
