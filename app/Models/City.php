<?php

namespace DatLichVietAPI\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function wards()
    {
    	return $this->hasMany('DatLichVietAPI\Models\Ward', 'city_id')->orderBy('name');
    }
}
