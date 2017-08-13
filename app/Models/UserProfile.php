<?php

namespace SiGeEdu\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'address', 'postal_code', 'number', 'complement', 'city', 'neighborhood', 'state',
    ];
}
