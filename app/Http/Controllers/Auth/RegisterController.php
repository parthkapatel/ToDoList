<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view("auth.register");
    }

    public function register(RegisterRequest $request)
    {
        try{
            $userData = $request->except(["confirm_password","_token"]);
            $user = User::create($userData);
            if($user){
                return response()->json([
                    "success" => true,
                    "message" => "Register Successfully"
                ]);
            }else{
                return response()->json([
                    "success" => false,
                    "message" => "Something is wrong to register user"
                ]);
            }
        }catch (\Exception $e){
            Log::info($e->getMessage());
            return response()->json([
                "success" => false,
                "message" => "Something went wrong"
            ]);
        }
    }
}
