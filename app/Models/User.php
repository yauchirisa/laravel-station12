<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as AuthenticatableUser;
use Illuminate\Notifications\Notifiable;

class User extends AuthenticatableUser implements Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'id',
        'email',
        'name',
        'password',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function reservation()
    {
        return $this->hasMany(Reservation::class);
    }

}
