<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;


class CreateScheduleRequest extends FormRequest
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
            'movie_id' => ['required'],
            'start_time_date' => ['required', 'date_format:Y-m-d', 'before_or_equal:end_time_date'],
            'start_time_time' => ['required', 'date_format:H:i', 'before:end_time_time',
            function ($attribute, $value, $fail) {
                // ここに処理を書く
                if (!preg_match('/^\d{1,2}:\d{2}$/', $value)) {
                    $fail('時間のフォーマットが無効です。');
                    return;
                    }
                $startTime = Carbon::createFromFormat('H:i', $value);
                $endTime = Carbon::createFromFormat('H:i', $this->input('end_time_time'));

                $diffInMinutes = $endTime->diffInMinutes($startTime);

                if ($diffInMinutes < 6) {
                    $fail("5分以上あけてください。");

                }
            },
        ],

            'end_time_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:start_time_date'],
            'end_time_time' => ['required', 'date_format:H:i', 'after:start_time_time',

            function ($attribute, $value, $fail) {
                if (!preg_match('/^\d{1,2}:\d{2}$/', $value)) {
                    $fail('時間のフォーマットが無効です。');
                    return;
                    }
                $endTime = Carbon::createFromFormat('H:i', $value);
                $startTime = Carbon::createFromFormat('H:i', $this->input('start_time_time'));

                $diffInMinutes = $endTime->diffInMinutes($startTime);

                if ($diffInMinutes < 6) {
                    $fail("5分以上あけてください。");

                }
            },
        ],
        ];
    }


}
