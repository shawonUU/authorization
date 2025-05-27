<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function getAllUsers()
    {
        return User::all();
    }

    public function getUserById($id)
    {
        return User::findOrFail($id);
    }

    public function createUser(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
            if (!empty($data['roles']) && is_array($data['roles'])) {
                $user->roles()->attach($data['roles']);
            }
            return $user;
        });
    }

    public function updateUser($id, array $data)
    {
        $user = User::findOrFail($id);

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        if (isset($data['roles']) && is_array($data['roles'])) {
            $user->roles()->sync($data['roles']);
        } else {
            $user->roles()->detach();
        }

        return $user;
    }

    public function deleteUser($id)
    {
        DB::transaction(function () use ($id) {
            $user = User::findOrFail($id);
            $user->roles()->detach();
            $user->delete();
        });
    }
}
