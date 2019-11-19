<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public function company(){
        return $this->belongsTo('App\Models\Company', 'company_id');
    }
}
