<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 28.08.2017
 * Time: 18:37
 */

namespace Api\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class TeamSpeakVirtualServerTokenCreateRequest extends FormRequest
{

    function rules(): array
    {
        return config('ApiValidation.TeamSpeak.VirtualServer.Token.Create.rules');
    }

    function messages(): array
    {
        return config('ApiValidation.TeamSpeak.VirtualServer.Token.Create.messages');
    }

    public function authorize()
    {
        return Auth::check();
    }

}