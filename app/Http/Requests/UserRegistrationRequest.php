<?php

namespace Api\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegistrationRequest extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules(): array {
		return config('ApiValidation.User.Registration.rules');
	}

	function messages(): array
	{
		return config('ApiValidation.User.Registration.messages');
	}

}
