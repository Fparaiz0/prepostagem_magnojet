<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class UserStatus extends Model implements Auditable
{
  use \OwenIt\Auditing\Auditable;

  protected $table = 'user_statuses';

  protected $fillable = ['name'];

  public function user()
  {
    return $this->hasMany(User::class);
  }
}
