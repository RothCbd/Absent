<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $casts = [
        'phone_number' => 'array'
    ];

    public function absent(){
        return $this->hasMany(Absent::class, 'employee_id');
    }

    public function position(){
        return $this->belongsTo(Position::class, 'postion_id');
    }
}
