<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Packaging extends Model implements Auditable
{
  use \OwenIt\Auditing\Auditable;

  protected $table = 'packagings';

  protected $fillable = [
    'packaging_id',
    'name',
    'height',
    'width',
    'length',
    'diameter',
    'weight',
    'active',
  ];
}
