<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Nuwave\Lighthouse\Exceptions\AuthenticationException;

class AuthMutation
{

    public function login($_, array $args)
    {
        // Check if a user with the specified email exists
        $user = User::where("email","=", $args['username'])->first();

        if (!$user) {
            throw new AuthenticationException(__('User Not Found'));
        }

        // If a user with the email was found - check if the specified password
        // belongs to this user
        if (!Hash::check($args['password'], $user->password)) {
            throw new AuthenticationException(__('Wrong password'));

        }
        // Send an internal API request to get an access token
        $client = DB::table('oauth_clients')
            ->where('password_client', true)
            ->first();

        // Make sure a Password Client exists in the DB
        if (!$client) {
            throw new AuthenticationException(__('Laravel Passport is not setup properly.'));
        }

        $data = [
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => $args['username'],
            'password' => $args['password'],
        ];

        $request = Request::create('/oauth/token', 'POST', $data);

        $response = app()->handle($request);

        // Check if the request was successful
        if ($response->getStatusCode() != 200) {
            throw new AuthenticationException(__('Incorrect username or password'));
        }
        // // Get the data from the response
        $data = json_decode($response->getContent(),true);

        // Format the final response in a desirable format
        return array_merge(
            $data,
            [
                'user' => $user,
            ]
        );
    }

    public function register($_, array $args)
    {
        $model = app(config('auth.providers.users.model'));
        $input = collect($args)->except('password_confirmation')->toArray();
        $model->fill($input);
        $model->save();


        return [
            'tokens' => [],
            'status' => 'MUST_VERIFY_EMAIL',
        ];
    }

    public function logout($_, array $args)
    {
        // revoke user's token
        Auth::guard('api')->user()->token()->revoke();

        return [
            'status'  => 'TOKEN_REVOKED',
            'message' => __('Your session has been terminated'),
        ];
    }
}
