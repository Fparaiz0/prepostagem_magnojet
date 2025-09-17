<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Sender extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    // Indicar o nome da tabela
    protected $table = 'senders';

    // Indicar quais colunas podem ser manipuladas
    protected $fillable = [
        'sender_id',
        'name',
        'cnpj',
        'cep',
        'public_place',
        'number',
        'neighborhood',
        'city',
        'uf',
    ];
}
