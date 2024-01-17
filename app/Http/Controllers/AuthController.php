<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $attributeNames = array(
                'email'    => $request->email,
                'password'     => $request->password,
                'type'      => $request->type,
            );
            $validator = Validator::make($attributeNames, [
                'email' => 'required|email',
                'type' => 'required|string',
                // 'password' => 'required|min:8'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'token' => null,
                    'message' => 'Login Error',
                    'error' => $validator->errors()
                ], 422);
            } else {
                try {
                    if ($request->type === 'manual') {
                        $user = User::where('email', $request->email)->where('is_active', true)->first();
                        if (
                            $user &&
                            Hash::check($request->password, $user->password)
                        ) {
                            $token = $user->createToken("token")->plainTextToken;
                            return response()->json([
                                'user' => $user,
                                'token' => $token,
                                'message' => 'Successful'
                            ], 200);
                        }
                        return response()->json([
                            'token' => null,
                            'message' => 'Unauthorized',
                            'error' => 'Unauthorized'
                        ], 410);
                    }
                } catch (Exception $e) {
                    return response()->json([
                        'message' => 'Email is not Registered',
                        'data' => null,
                        'error' => $e->getMessage()
                    ], 410);
                }
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Opps! An Exception',
                'data' => null,
                'error' => $e->getMessage()
            ], 410);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Opps! A Query Exception',
                'data' => null,
                'error' => $e->getMessage()
            ], 411);
        }
    }
}
