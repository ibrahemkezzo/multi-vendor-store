<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AccessTokenController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'email'=>['required','email','max:255'],
            'password'=>['required','string','min:6'],
            'device_name'=>['string','max:255'],
            'abilities'=>['nullable','array'],
        ]);

        $user = User::where('email',$request->email)->first();
        if($user && Hash::check($request->password,$user->password)){
            $device_name = ($request->device_name)?$request->device_name:$request->userAgent();
            // return $device_name;
            $token = $user->createToken($device_name,$request->post('abilities'));
            return response()->json([
                'code'=>1,
                'token'=>$token->plainTextToken,
                'user'=>$user,
        ], 201);
        }
        return response()->json(['code'=>0,'message'=>'invalid credentials'], 401);
    }

    public function destroy($token = null){
        $user = Auth::guard('sanctum')->user();
        //revoke all token
        // $user->tokens()->delete();
        if(null===$token){
            $user->currentAccessToken()->delete();
            return response()->json(['home'=>route('front.home')],201);
        }
        $personalaccesstoken = PersonalAccessToken::findToken($token);
        if($user->id==$personalaccesstoken->token_id && get_class($user) == $personalaccesstoken->token_type){
            $personalaccesstoken->delete();
            return response()->json(['message'=>'success deleted'],201);
        }
    }
}
