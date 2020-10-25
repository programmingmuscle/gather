<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'title'       => 'required|string|max:191',
			'date_time'   => 'required|date|max:191',
			'end_time'    => 'required|date|after:date_time|max:191',
			'place'       => 'required|string|max:191',
			'address'     => 'required|string|max:191',
			'reservation' => 'required|string|max:191',
			'expense'     => 'required|string|max:191',
			'ball'        => 'required|string|max:191',
			'deadline'    => 'required|date|before:date_time|max:191',
			'people'      => 'required|string|max:191',
			'remarks'     => 'string|nullable|max:191',
        ];
    }

    public function messages()
    {
        return [
            'title.required'        => 'タイトルを入力して下さい。',
			'title.string'          => 'タイトルは文字列として下さい。',
			'title.max'             => 'タイトルは191文字以内として下さい。',
			'date_time.required'    => '開始日時を入力して下さい。',
			'date_time.date'        => '開始日時は日付の文字列として下さい。',
			'date_time.max'         => '開始日時は191文字以内として下さい。',
			'end_time.required'     => '終了日時を入力して下さい。',
			'end_time.date'         => '終了日時は日付の文字列として下さい。',
			'end_time.after'        => '終了日時は開始日時より後の日時として下さい。',
			'end_time.max'          => '終了日時は191文字以内として下さい。',
			'place.required'        => '場所を入力して下さい。',
			'place.string'          => '場所は文字列として下さい。',
			'place.max'             => '場所は191文字以内として下さい。',
			'address.required'      => '住所を入力して下さい。',
			'address.string'        => '住所は文字列として下さい。',
			'address.max'           => '住所は191文字以内として下さい。',
			'reservation.required'  => '場所予約を入力して下さい。',
			'reservation.stirng'    => '場所予約は文字列として下さい。',
			'reservation.max'       => '場所予約は191文字以内として下さい。',
			'expense.required'      => '参加費用を入力して下さい。',
			'expense.string'        => '参加費用は文字列として下さい。',
			'expense.max'           => '参加費用は191文字以内として下さい。',
			'ball.required'         => '使用球を入力して下さい。',
			'ball.string'           => '使用球は文字列として下さい。',
			'ball.max'              => '使用球は191文字以内として下さい。',
			'deadline.required'     => '締切日時を入力して下さい。',
			'deadline.date'         => '締切日時は日付の文字列として下さい。',
			'deadline.before'       => '締切日時は開始日時より前の日時として下さい。',
			'deadline.max'          => '締切日時は191文字以内として下さい。',
			'people.required'       => '募集人数を入力して下さい。',
			'people.string'         => '募集人数は文字列として下さい。',
			'people.max'            => '募集人数は191文字以内として下さい。',
			'remarks.string'        => '備考は文字列として下さい。',
			'remarks.max'           => '備考は191文字以内として下さい。',
        ];
    }
}
