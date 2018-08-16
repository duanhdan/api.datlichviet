<?php

namespace DatLichVietAPI\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    public function employees()
    {
    	return $this->belongsToMany('DatLichVietAPI\Models\Employee', 'branch_employees', 'branch_id', 'employee_id')
    			->withPivot(['branch_id', 'employee_id', 'employee_role_id']);
    }

    public function services()
    {
    	return $this->belongsToMany('DatLichVietAPI\Models\Service', 'branch_services', 'branch_id', 'service_id');
    }
}
