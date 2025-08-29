<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Classe de requisição para validação de cursos.
 *
 * Responsável por definir as regras de validação e mensagens de erro 
 * para operações relacionadas a cursos, como criação e edição.
 *
 * @package App\Http\Requests
 */
class PackagingRequest extends FormRequest
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
        $packaging = $this->route('packaging');

        return [
            'name'     => 'required|unique:packagings,name,' . ($packaging ? $packaging->id : 'NULL'),
            'height'   => 'required|integer|min:0',
            'width'    => 'required|integer|min:0',
            'length'   => 'required|integer|min:0',
            'diameter' => 'required|integer|min:0',
            'weight'   => 'required|integer|min:0',
            'active'   => 'required|boolean',
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
            'name.unique' => "O nome já está cadastrado!",
            'height.required' => "Campo altura é obrigatório!",
            'width.required' => "Campo largura é obrigatório!",
            'length.required' => "Campo comprimento é obrigatório!",
            'diameter.required' => "Campo diâmetro é obrigatório!",
            'weight.required' => "Campo peso é obrigatório!",
        ];
    }
}
