<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
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
            'content' => 'required|string|max:191',
        ];
    }

    public function messages()
    {
        return [
            'content.required' => '空のメッセージは送信できません。',
			'content.string'   => 'メッセージは文字列として下さい。',
			'content.max'      => 'メッセージは191文字以内として下さい。',
        ];
    }
}
