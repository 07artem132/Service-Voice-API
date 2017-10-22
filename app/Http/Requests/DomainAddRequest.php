<?php

namespace Api\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DomainAddRequest extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return Auth::check();
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules(): array {
		return config( 'ApiValidation.Domain.Create.rules' );
	}

	public function messages(): array {
		return config( 'ApiValidation.Domain.Create.messages' );
	}
}
