<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrePostagemRequest extends FormRequest
{

  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    $prepostagem = $this->route('prepostagem');

    return [
      // 'code_object' => 'required|unique:prepostagens,code_object,' . ($prepostagem ? $prepostagem->id : null),
    ];
  }

  public function messages(): array
  {
    return [
      'code_object.required' => 'Campo codigo de rastreamento é obrigatório!',
      'code_object.unique' => 'O codigo de rastreamento já foi utilizado!',
    ];
  }
}
