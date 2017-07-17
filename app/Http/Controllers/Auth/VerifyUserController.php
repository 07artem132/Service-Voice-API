<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 27.06.2017
 * Time: 15:58
 */

namespace Api\Http\Controllers\Auth;

use Api\Http\Controllers\Auth\RegisterController;
use Api\Http\Controllers\Controller;
use Api\Services\WHMCS\API;
use Sentinel;
use Auth;

class VerifyUserController extends Controller
{
    private static $BillingApi;
    private static $BillingApiResponse;
    private static $user;

    public static function BillingAccountVerify($credentials)
    {
        self::$BillingApi = new API();
        self::$BillingApiResponse = self::$BillingApi->ValidateCredentials($credentials);
        return self::$BillingApiResponse;
    }

    public static function AccountVerify($credentials)
    {
        self::BillingAccountVerify($credentials);
        self::LocalAccountVerify($credentials);
    }

    public static function LocalAccountVerify($credentials)
    {
        if (Auth::validate($credentials) === false) {
            self::$user = Sentinel::findByCredentials([username() => $credentials[username()]]);

            if (self::$user === null)
                self::$user = RegisterController::Registration($credentials);

            if (!self::VerifiPassword($credentials['password'], self::$user->password)) {
                self::ChangePassword($credentials['password']);
            }
        }
        return;
    }

    private static function ChangePassword($InputPassword)
    {
        Sentinel::update(self::$user, array('password' => $InputPassword));
    }

    public static function VerifiPassword($InputPassword, $UserPassword)
    {
        return Sentinel::getHasher()->check($InputPassword, $UserPassword);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }
}