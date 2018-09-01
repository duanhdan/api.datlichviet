<?php

namespace DatLichVietAPI;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'phone', 'type', 'status'
    ];

    public function profile()
    {
        return $this->hasOne('DatLichVietAPI\Models\UserProfile', 'user_id');
    }

    public function verify()
    {
        return $this->hasMany('DatLichVietAPI\Models\UserVerification', 'user_id');
    }

    public function customers()
    {
        return $this->belongsToMany('DatLichVietAPI\Models\Customer', 'user_customers', 'user_id', 'customer_id');
    }

    public function device()
    {
        return $this->hasOne('DatLichVietAPI\Models\UserDevice', 'user_id');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}