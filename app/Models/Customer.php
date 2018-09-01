<?php

namespace DatLichVietAPI\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'full_name', 'gender', 'dob', 'address', 'ward', 'city', 'province', 'blood'
    ];
}
