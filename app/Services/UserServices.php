<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

final class UserServices
{
    /**
     * Return current user in the session
     *
     * @return array
     */
    public static function currentUser(): array
    {
        $user = [
            'user_id' => 0,
            'user_name' => '',
            'user_surname' => '',
            'user_mobile' => '',
            'user_email' => ''
        ];
        if (Auth::user()?->id != null) {
            $currentUser = User::find(Auth::user()?->id);
            $user["user_id"] = $currentUser->id;
            $user["user_name"] = $currentUser->name;
            $user["user_surname"] = $currentUser->surname;
            $user["user_mobile"] = $currentUser->mobile;
            $user["user_email"] = $currentUser->email;
        }
        return $user;
    }
    /**
     * Return if user_id is valid
     *
     * @param [int] $id
     * @return boolean
     */
    public static function currentUserIdIsValid($id): bool
    {
        if (Auth::user()?->id != null) {
            return Auth::user()?->id == $id;
        } elseif ($id == 0) {
            return true;
        } else {
            return false;
        }
    }
}
