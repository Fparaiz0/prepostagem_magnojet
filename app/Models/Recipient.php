<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Recipient extends Model implements Auditable
{
  use \OwenIt\Auditing\Auditable;

  protected $table = 'recipients';

  protected $fillable = [
    'recipient_id',
    'name',
    'cnpj',
    'cep',
    'public_place',
    'number',
    'complement',
    'neighborhood',
    'city',
    'uf',
  ];
}
