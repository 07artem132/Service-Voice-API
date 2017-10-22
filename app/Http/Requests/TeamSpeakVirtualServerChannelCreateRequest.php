<?php

namespace Api\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TeamSpeakVirtualServerChannelCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return config('ApiValidation.TeamSpeak.VirtualServer.channel.create.rules');
    }
    public function messages() {
	    return config('ApiValidation.TeamSpeak.VirtualServer.channel.create.messages');
    }
}
