<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class ManagementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        return [

            'restraint_start_time' => 'required',
            'restraint_closing_time'  => ['required', 'after:restraint_start_time'],
        ];
    }

    public function messages()
    {
        return [
            'restraint_start_time.required' => '始業時間を指定してください',
            'restraint_start_time.required' => '終業時間を指定してください',
        ];
    }
}
