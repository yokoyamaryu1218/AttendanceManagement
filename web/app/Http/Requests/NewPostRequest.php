<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Rules\JapaneseAndAlphaNumRule;
use App\Rules\PasswordRule;

class NewPostRequest extends FormRequest
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
            'name' => ['required', 'max:32', new JapaneseAndAlphaNumRule],
            'password' => ['required', 'string', 'min:8', new PasswordRule],
            'management_emplo_id' => 'required',
            'restraint_start_time' => 'required',
            'restraint_closing_time'  => ['required', 'after:restraint_start_time'],
            'daily' => ['nullable', 'max:1024'],
        ];
    }

    public function messages()
    {
        return [
            'daily.max' => '日報は1,024文字以内で入力してください',
            'name.required' => '社員名を入力してください',
            'name.max' => '社員名は32文字以内で入力してください',
            'password.required' => 'パスワードを入力してください',
            'password.min' => 'パスワードは8文字以上で入力してください',
            'management_emplo_id.required' => '管理者検索をしてください',
            'restraint_start_time.required' => '始業時間を指定してください',
            'restraint_start_time.required' => '終業時間を指定してください',
        ];
    }
}
