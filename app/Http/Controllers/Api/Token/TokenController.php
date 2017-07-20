<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 04.07.2017
 * Time: 22:27
 */

namespace Api\Http\Controllers\Api\Token;

use Api\Traits\RestSuccessResponseTrait;
use Api\UserToken;
use Auth;

class TokenController extends Controller
{
    use RestSuccessResponseTrait;

    function Delete($token)
    {
        UserToken::where('token', '=', $token)->delete();
        return $this->jsonResponse();
    }

    function UserTokenList()
    {
        $Tokens = UserToken::User(Auth::id())->get();

        return $this->jsonResponse($Tokens);
    }

    function AllTokenList()
    {
        $Tokens = UserToken::withTrashed()->get();
        $Tokens = $Tokens->makeVisible(['Blocked', 'user_id', 'deleted_at'])->toArray();

        return $this->jsonResponse($Tokens);
    }

    function Create()
    {
        $token = str_random(100);

        $TokenDbSave = new UserToken;
        $TokenDbSave->user_id = Auth::id();
        $TokenDbSave->token = $token;
        $TokenDbSave->scope = '*';
        $TokenDbSave->allow_ip = '';
        $TokenDbSave->app_type = 1;
        $TokenDbSave->Blocked = 0;
        $TokenDbSave->save();

        $token = UserToken::User(Auth::id())->Token($token)->get();

        return $this->jsonResponse($token);
    }

}