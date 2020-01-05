<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Data;

class Category extends Model
{
    public function datas() {
        return $this->hasMany(Data::class);
    }
}
