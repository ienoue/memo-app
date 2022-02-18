<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class MemoRequest extends FormRequest
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
        return [
            'content' => 'required|not_regex:/^[\s　]+$/',
            'tag' => 'nullable|not_regex:/^[\s　]+$/',
        ];
    }

    public function messages()
    {
        return [
            'content.required' => 'テキストが入力されていません。',
            'content.not_regex' => 'スペースのみの入力は認められていません',
            'tag.not_regex' => 'スペースのみの入力は認められていません',
        ];
    }
}
