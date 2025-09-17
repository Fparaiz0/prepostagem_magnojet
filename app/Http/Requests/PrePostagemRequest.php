<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Classe de requisição para validação de cursos.
 *
 * Responsável por definir as regras de validação e mensagens de erro
 * para operações relacionadas a cursos, como criação e edição.
 */
class PrePostagemRequest extends FormRequest
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
        $prepostagem = $this->route('prepostagem');

        return [
            // 'code_object' => 'required|unique:prepostagens,code_object,' . ($prepostagem ? $prepostagem->id : null),
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
            'code_object.required' => 'Campo codigo de rastreamento é obrigatório!',
            'code_object.unique' => 'O codigo de rastreamento já foi utilizado!',
        ];
    }
}
