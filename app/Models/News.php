<?php

namespace DatLichVietAPI\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    public function category()
    {
    	return $this->belongsTo('DatLichVietAPI\Models\Category', 'category_id');
    }
}
