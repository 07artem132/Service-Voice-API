<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 27.06.2017
 * Time: 15:37
 */

namespace Api\Http\Controllers\Auth;

use Api\Http\Controllers\Controller;
use Sentinel;

class RegisterController extends Controller
{
    private static $roleName = 'Client';
    private static $user;
    private static $role;

    public static function Registration($credentials)
    {
        self::$user = Sentinel::registerAndActivate($credentials);
        self::$role = Sentinel::findRoleByName(self::$roleName);

        self::$role->users()->attach(self::$user);

        self::Complete();

        return self::$user;
    }

    public static function Complete()
    {
        return;
    }
}