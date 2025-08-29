<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Prepostagem extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    // Indicar o nome da tabela
    protected $table = 'prepostagens';

    // Indicar quais colunas podem ser manipuladas
        protected $fillable =  [
            'prepostagem_id',
            'name_sender',
            'cnpj_sender',
            'cep_sender',
            'public_place_sender',
            'number_sender',
            'neighborhood_sender',
            'city_sender',
            'uf_sender',
            'name_recipient',
            'cnpj_recipient'  ,
            'cep_recipient',
            'public_place_recipient',
            'number_recipient',
            'neighborhood_recipient',
            'city_recipient',
            'uf_recipient',
            'code_service',
            'object_code',
            'invoice_number',
            'nfe_key',
            'weight_informed',
            'code_format_informed_object',
            'height_informed',
            'width_informed',
            'length_informed',
            'diameter_informed', 
            'aware_object_not_forbidden',
            'payment_method', 
            'situation', 
            'observation',
            'complement_recipient', 
        ];
}