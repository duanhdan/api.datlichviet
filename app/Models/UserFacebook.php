<?php

namespace DatLichVietAPI\Models;

use Illuminate\Database\Eloquent\Model;

class UserFacebook extends Model
{
	protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_id', 'access_token'
    ];
}
