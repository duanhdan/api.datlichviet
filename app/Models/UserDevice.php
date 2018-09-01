<?php

namespace DatLichVietAPI\Models;

use Illuminate\Database\Eloquent\Model;

class UserDevice extends Model
{
    protected $fillable = [
        'user_id', 'type', 'token','status'
    ];
}
