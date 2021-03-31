<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\ApiKey;

class AuthController extends Controller
{
  

    public function getToken(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'secret_key' => 'required|string',
            'remember_me' => 'boolean'
        ]);


        $key = ApiKey::where('key', $request->secret_key)->get();

        // if($key->count() < 1){
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'You are not allowed to use this api.'
        //     ]);
        // } else {
            $credentials = request(['email', 'password']);
            if(!Auth::attempt($credentials))
                return response()->json([
                    'message' => 'Access Denied'
                ], 401);
            $user = $request->user();
            // if($user->id != $key[0]->uid || !$key[0]->status){
            //     return response()->json([
            //         'status' => false,
            //         'message' => 'You are not allowed to use this api.'
            //     ]);
            // }
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            if ($request->remember_me)
                $token->expires_at = Carbon::now()->addWeeks(1);
            $token->save();
            return response()->json([
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString()
            ]);
            }
    // }
   
}