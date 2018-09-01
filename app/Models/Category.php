<?php

namespace DatLichVietAPI\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function posts()
    {
    	return $this->hasMany('DatLichVietAPI\Models\News', 'category_id');
    }
}
