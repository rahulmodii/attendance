<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recharge extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function package(){
        return $this->belongsTo(Packages::class,'package_id');
    }

    public function rechargeBy(){
        return $this->belongsTo(User::class,'recharge_by');
    }
}
