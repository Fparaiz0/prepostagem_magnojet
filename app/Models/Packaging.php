<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Packaging extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    // Indicar o nome da tabela
    protected $table = 'packagings';

    // Indicar quais colunas podem ser manipuladas
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
