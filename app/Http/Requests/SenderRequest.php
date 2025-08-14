<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Classe de requisição para validação de cursos.
 *
 * Responsável por definir as regras de validação e mensagens de erro 
 * para operações relacionadas a cursos, como criação e edição.
 *
 * @package App\Http\Requests
 */
class SenderRequest extends FormRequest
{
    /**
     * Determina se o usuário está autorizado a fazer esta requisição.
     *
     * @return bool Retorna true para permitir a requisição.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Retorna as regras de validação aplicáveis à requisição.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string> 
     * Regras de validação.
     */
    public function rules(): array
    {
        $sender = $this->route('sender');

        return [
        'name' => ['required', 'string', 'max:255'],
        'cnpj' => [
            'required',
            'string',
            Rule::unique('senders', 'cnpj')->ignore($sender?->id),
        ],
        'cep' => ['required', 'string'],
        'public_place' => ['required', 'string'],
        'number' => ['required', 'string'],
        'city' => ['required', 'string'],
        'uf' => ['required', 'string', 'size:2'],
        ];
    }

    /**
     * Define mensagens personalizadas para as regras de validação.
     *
     * @return array<string, string> Mensagens de erro personalizadas.
     */
    public function messages(): array
    {
        return [
            'name.required' => "Campo nome é obrigatório!",
            'cnpj.required' => "Campo Cnpj é obrigatório!",
            'cnpj.unique' => "O CNPJ informado já está cadastrado!",
            'cep.required' => "Campo Cep é obrigatório!",
            'public_place.required' => "Campo Logradouro é obrigatório!",
            'number.required' => "Campo Número é obrigatório!",
            'city.required' => "Campo Cidade é obrigatório!",
            'uf.required' => "Campo UF é obrigatório!", 
        ];
    }
}
