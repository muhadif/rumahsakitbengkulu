<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Data;

class Doctor extends Model
{
    public function datas() {
        return $this->hasMany(Data::class);
    }
}
