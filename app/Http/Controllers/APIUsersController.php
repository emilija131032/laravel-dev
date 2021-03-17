<?php

namespace App\Http\Controllers;

use App\Features\Users\GetUsersFeature;
use App\Models\User;
use App\Models\PersonalUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class APIUsersController extends Controller
{
    public function getUsers(Request $request){

        return GetUsersFeature::handle($request);
    }

    public function addUser(Request $request){

        $user = new User();
        $user->email = $request->email;

        $user->save();
    }

    public function register(Request $request) {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        try {
            DB::beginTransaction();

            $personal_user = new PersonalUser();
            $personal_user->first_name = $request->first_name;
            $personal_user->last_name = $request->last_name;
            $personal_user->signed_up = 1;
            $personal_user->status = 1;

            $personal_user->save();

            $user = User::create([
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'userable_type' => 'App\Models\PersonalUser',
                'userable_id' => $personal_user->id,
            ]);

            $user->remember_token = Str::random(10);

            $user->save();

            DB::commit();

            User::sendWelcomeMail($user);

            return response()->json(['status' => 'success', 'data' => $user], $this->successStatus);
        }
        catch (\Exception $e) {
            return $e;
        }
    }

    public function disableUser(Request $request, $id){

        $user = User::find($id);

        $personal_user = PersonalUser::find($user->userable_id);

        $personal_user->status = 0;

        $personal_user->save();


        return response([
            'status' => 'success',
        ], 200);

    }
}
