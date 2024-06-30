<?php

namespace App\Http\Requests;
use Illuminate\Support\Carbon;


use Illuminate\Foundation\Http\FormRequest;

class UpdateScheduleRequest extends FormRequest
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
                if (!preg_match('/^\d{1,2}:\d{2}$/', $value)) {
                    $fail('時間のフォーマットが無効です。');
                    return;
                    }
           $startTime = new Carbon($this->start_time_time);
           $endTime = new Carbon($this->end_time_time);

           $diffInMinutes = $endTime->diffInMinutes($startTime);

           if($diffInMinutes < 6) {
                $fail("5分以上あけてください。");
            return redirect('/admin/schedules/{scheduleId}/edit');
           }


            },],

            'end_time_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:start_time_date'],
            'end_time_time' => ['required', 'date_format:H:i', 'after:start_time_time',
            function ($attribute, $value = null, $fail) {
                if (!preg_match('/^\d{1,2}:\d{2}$/', $value)) {
                    $fail('時間のフォーマットが無効です。');
                    return;
                    }
           $startTime = new Carbon($this->start_time_time);
           $endTime = new Carbon($this->end_time_time);

           $diffInMinutes = $endTime->diffInMinutes($startTime);

            if($diffInMinutes < 6) {
                $fail("5分以上あけてください。");
            return redirect('/admin/schedules/{scheduleId}/edit');
           }
            },],
        ];
    }

    /*public function withValidator($validator)
    {
    $validator->after(function ($validator) {
        $startTime = strtotime($this->start_time_date . ' ' . $this->start_time_time);
        $endTime = strtotime($this->end_time_date . ' ' . $this->end_time_time);

        $startTime = new Carbon($this->start_time_time);
        $endTime = new Carbon($this->end_time_time);

        // 開始時間が終了時間より後であればエラー
        if ($startTime >= $endTime) {
            $validator->errors()->add('start_time_time', '時間を確認してください');
        }

        // 開始時間と終了時間が同じであればエラー
        if ($startTime === $endTime) {
            $validator->errors()->add('start_time_time', '時間を確認してください');
        }

        // 開始時間と終了時間の差が5分未満であればエラー
        if (abs($startTime - $endTime) < 5 ) {
            $validator->errors()->add('start_time_time', '5分以上あけてください');
        }
        });

    }*/
}
