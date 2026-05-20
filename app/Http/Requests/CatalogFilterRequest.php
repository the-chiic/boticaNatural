<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CatalogFilterRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'categories' => 'nullable|array',
            'categories.*' => 'integer|exists:categories,id',
            'search' => 'nullable|string|max:255',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0',
            'sort' => 'nullable|string|in:price_asc,price_desc,name_asc,name_desc,newest,oldest',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'categories.*.integer' => 'Las categorias deben ser identificadores validos.',
            'categories.*.exists' => 'Una o mas categorias no existen.',
            'search.string' => 'El termino de busqueda debe ser texto.',
            'search.max' => 'El termino de busqueda es demasiado largo.',
            'min_price.numeric' => 'El precio minimo debe ser un numero.',
            'min_price.min' => 'El precio minimo no puede ser negativo.',
            'max_price.numeric' => 'El precio maximo debe ser un numero.',
            'max_price.min' => 'El precio maximo no puede ser negativo.',
            'sort.in' => 'El ordenamiento seleccionado no es valido.',
        ];
    }
}
