<?php

namespace SiGeEdu\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    public function user(){
        return $this->morphOne(User::class, 'userable');
    }
}
