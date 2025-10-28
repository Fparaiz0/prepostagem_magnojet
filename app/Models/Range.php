<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Range extends Model implements Auditable
{
  use \OwenIt\Auditing\Auditable;

  protected $table = 'correios_etiquetas';

  protected $fillable = [
    'correios_etiquetas_id',
    'object_code',
    'used',
    'selected',
    'invoice',
  ];
}
