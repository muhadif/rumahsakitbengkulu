<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Category;
use App\Doctor;

class Datum extends Model
{

    public $incrementing = false;

    public function employee() {
        return $this->belongsTo(User::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function doctor() {
        return $this->belongsTo(Doctor::class);
    }
}
