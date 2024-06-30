<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'column', 'row',
    ];

    public function reservations() {
        return $this->hasMany('App\Models\Reservation');
    }



}
