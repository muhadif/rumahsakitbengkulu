<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Patient extends Model
{
    public function employee() {
        return $this->belongsTo(User::class);
    }
}
