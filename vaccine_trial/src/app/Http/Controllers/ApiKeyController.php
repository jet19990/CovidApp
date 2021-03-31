<?php

namespace App\Http\Controllers;

use App\ApiKey;
use App\User;
use Illuminate\Http\Request;
use  App\Http\Resources\ApiKeyCollection;

class ApiKeyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ApiKeyCollection::collection(ApiKey::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $apiKey = new ApiKey;

        $uid = auth('api')->user()->id;

        $apiKey->uid = $uid;
        $apiKey->key = ApiKeyController::generateRandomString(30);
        $apiKey->status = false; 

        if($apiKey->save()){
            return $apiKey;
        } 
        return response()->json([
            'status' => false,
            'message' => 'An error occured, Try again later'
        ]);
    }

    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ApiKey  $apiKey
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $userid = auth('api')->user()->id;
        $key = ApiKey::where('uid', $userid)->first();

        return $key;
    }

    
    public function approveApiKey($id)
    {
        try {
            $key = ApiKey::find($id);
            $user = User::find($key->uid);
            $user->role = $user->role == 3 ? 3 : 2;
            $user->save();
            $key->status = true;

            if($key->save()){
                return response()->json([
                    'status' => true,
                    'message' => 'Api Key request Approved successfully'
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Oops, An error occurred please try gain later'
            ]);
        }

       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ApiKey  $apiKey
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        $userid = auth('api')->user()->id;
        $apiKey = ApiKey::where('uid', $userid)->first();
        $apiKey->key = ApiKeyController::generateRandomString(30);

        if($apiKey->save()){
            return $apiKey;
        } 
        return response()->json([
            'status' => false,
            'message' => 'An error occured, Try again later'
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ApiKey  $apiKey
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $key = ApiKey::find($id);
            $user = User::find($key->uid);
            $user->role = $user->role == 3 ? 3 : 1;
            $user->save();
            if($key->delete()){
                return response()->json([
                    'status' => true,
                    'message' => 'Request was canceled successfully'
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'An error occured, Try again later'
            ]);
        }
    }
}
