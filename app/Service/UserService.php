<?php
namespace App\Service;

use App\InterfaceService\UserInterface;
use App\User; // model
use Illuminate\Support\Facades\Hash;

class UserService implements UserInterface
{
    public function getAllUser()
    {
        $users = User::all();

        return $users;
    }

    public function getUserById($id)
    {
        $user = User::find($id);

        return $user;
    }

    public function deleteUserById($id)
    {
        User::destroy($id);
    }

    public function createUser($request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
    }

    public function updateUser($request, $id)
    {
        $user = User::find($id);
        if(!$user) abort('404');
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
    }
}

