<?php

namespace DatLichVietAPI\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    public function cities()
    {
    	return $this->hasMany('DatLichVietAPI\Models\City', 'province_id')->orderBy('name');
    }
}
