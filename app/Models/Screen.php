<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Screen extends Model
{
    protected $fillable = ['name'];

    // スケジュールとのリレーションシップ
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

}
