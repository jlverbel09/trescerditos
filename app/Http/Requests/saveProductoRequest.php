<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class saveProductoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id_producto' => 'required|unique:productos',
            'nombre1' => 'required',
            'nombre2' => 'required',
            'precio' => 'required',
            'comentario' => 'required'
        ];
    }
}
