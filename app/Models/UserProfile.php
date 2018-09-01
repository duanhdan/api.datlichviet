<?php

namespace DatLichVietAPI\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
	protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_id', 'full_name', 'gender', 'dob', 'avatar', 'address', 'ward', 'city', 'province'
    ];
}
