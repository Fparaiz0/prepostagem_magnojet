<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CorreiosToken extends Model
{
    protected $fillable = ['token', 'valid_until'];
}
