<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class MonthlyRequest extends FormRequest
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
            'first_day' => 'required|date',
            'end_day' => ['required', 'date', 'after_or_equal:first_day', function ($attribute, $value, $fail) use ($request) {
                $first_day = $request->input('first_day');
                $end_day = $request->input('end_day');
                $diffInDays = strtotime($end_day) - strtotime($first_day);
                $days = floor($diffInDays / (60 * 60 * 24));

                if ($days > 30) {
                    $fail('日付は30日以内で指定してください。');
                }
            }],
        ];
    }

    public function messages()
    {
        return [
            //
        ];
    }
}
