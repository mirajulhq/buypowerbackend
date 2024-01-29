<?php

namespace Modules\User\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Modules\Settings\App\Models\SetState;
use Modules\Settings\App\Models\SetSuburb;
use Modules\User\App\Models\UserProfile;
use Modules\User\App\Models\UserSuburb;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user::index');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $attributeNames = array(
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => $request->password,
            );
            $validator = Validator::make($attributeNames, [
                'email' => 'required',
                'password' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation Error',
                    'data' => null,
                    'error' => $validator->errors()
                ], 422);
            } else {
                $user_id = '';
                $user_profile_id = '';
                DB::transaction(function () use ($request, &$user_id, &$user_profile_id) {
                    $user = new User();
                    $user->name = $request->first_name . ' ' . $request->last_name;
                    $user->first_name = $request->first_name;
                    $user->last_name = $request->last_name;
                    $user->email = $request->email;
                    $user->password = Hash::make($request->password);
                    $user->save();
                    $user_id = $user->id;
                    $userProfile = new UserProfile();
                    $userProfile->user_id = $user_id;
                    $userProfile->save();
                    $user_profile_id = $userProfile->id;
                });
                return response()->json([
                    'message' => 'User created successfully',
                    'user_id' => $user_id,
                    'user_profile_id' => $user_profile_id,
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Opps! An Exception',
                'data' => null,
                'error' => $e->getMessage()
            ], 410);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeSurvey(Request $request, $id): JsonResponse
    {
        try {
            if (isset($request->suburb) && $request->suburbList === 1) {
                if (count($request->suburb) > 0) {
                    DB::transaction(function () use ($request, $id) {
                        foreach ($request->suburb as $key => $value) {
                            $user_suburb = new UserSuburb();
                            $user_suburb->user_profile_id = $id;
                            $user_suburb->suburb_id = $value;
                            $user_suburb->create_user_id = auth('sanctum')->user()->id;
                            $user_suburb->save();
                        }
                    });
                }
            }
            if (isset($request->region) && $request->region === true) {
                $geoCoding = new GeocodingController();
                $region = $geoCoding->getRegionInfo($request->latitude, $request->longitude);
                // $state = SetState::where('state', 'Like', '%' . $region . '%')->with('suburb:id,suburb,state_id')->first();
                $state = SetState::where('state', $region)->with('suburb:id,suburb,state_id')->first();
                foreach ($state->suburb as $key => $value) {
                    $user_suburb = new UserSuburb();
                    $user_suburb->user_profile_id = $id;
                    $user_suburb->suburb_id = $value->id;
                    $user_suburb->create_user_id = auth('sanctum')->user()->id;
                    $user_suburb->save();
                }
            }
            return response()->json([
                'message' => 'User created successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Opps! An Exception',
                'data' => null,
                'error' => $e->getMessage()
            ], 410);
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('user::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('user::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): JsonResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
