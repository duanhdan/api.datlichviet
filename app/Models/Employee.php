<?php

namespace DatLichVietAPI\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public function branch()
    {
    	return $this->belongsTo('DatLichVietAPI\Models\Branch', 'branch_employees', 'employee_id', 'branch_id');
    }

    public function specialty()
    {
    	return $this->belongsToMany('DatLichVietAPI\Models\Specialty', 'employee_specialties', 'employee_id', 'specialty_id');
    }
}
