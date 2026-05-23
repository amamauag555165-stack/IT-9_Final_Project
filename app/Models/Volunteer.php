<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    protected $fillable =[
    'gender',
    'marital_status',
    'user_id'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::Class);
    }
}
