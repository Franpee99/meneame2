<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNoticiaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; //Lo pones a true para que si tenga autorizacion
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'titular' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'categoria_id' => 'required|exists:categorias,id',
            //'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}
