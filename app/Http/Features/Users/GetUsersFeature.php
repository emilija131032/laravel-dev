<?php

namespace App\Features\Users;

use App\Models\User;
use App\Support\Interfaces\FeatureInterface;
use Illuminate\Http\Request;


class GetUsersFeature implements FeatureInterface
{
    /**
     * @param Request $request
     * @return mixed
     */
    public static function handle($request)
    {
        try {
            return (new static)->getUsers($request);
        } catch (\Exception $ex) {
            dd($ex);
        }
    }

    /**
     * @param $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getUsers($request)
    {
            $users = User::select('*')
                ->where('userable_type', 'App\Models\PersonalUser');

            return $users;
    }
}
