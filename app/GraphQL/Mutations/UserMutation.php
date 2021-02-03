<?php

namespace App\GraphQL\Mutations;

use App\Models\User;

class UserMutation
{
    public function create($_,array $args)
    {
        return User::create($args);
    }

    public function update($_,array $args)
    {
        $user = User::find($args['id']);

        if ($user->update($args)) {
            return $user;
        }
    }

    public function delete($_,array $args)
    {
        $user = User::find($args['id']);

        if ($user->delete()) {
            return $user;
        }
    }
}
