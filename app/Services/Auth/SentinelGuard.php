<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 26.06.2017
 * Time: 15:27
 */
namespace Api\Services\Auth;

use Sentinel;
use Sentry;

class SentinelGuard
{

    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check()
    {
        return Sentry::check();
    }

    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest()
    {
        return Sentinel::guest();
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        return Sentinel::getUser();
    }

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return int|null
     */
    public function id()
    {
        $user = Sentry::getUser();
        return $user->id;
    }

    /**
     * Validate a user's credentials.
     *
     * @param  array $credentials
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        $user = Sentinel::authenticate($credentials);
        return $user;
    }

    /**
     * @param Authenticatable $user
     */
    public function setUser(Authenticatable $user)
    {
        Sentinel::login($user);
    }

}