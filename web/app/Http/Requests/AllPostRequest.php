<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Rules\JapaneseAndAlphaNumRule;
use App\Rules\PasswordRule;

class AllPostRequest extends FormRequest
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
    public function rules()
    {
        return [
            'daily' => ['nullable', 'max:1024'],
            'name' => ['required', 'max:32', new JapaneseAndAlphaNumRule],
            'password' => ['min:8', 'max:256', new PasswordRule],
            'management_emplo_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'daily.max' => '日報は1,024文字以内で入力してください',
            'name.required' => '名前を入力してください',
            'name.max' => '名前は32文字以内で入力してください',
            'password.min' => 'パスワードは8文字以上で入力してください',
            'management_emplo_id.required' => '管理者検索をしてください',
        ];
    }
}
