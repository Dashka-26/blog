<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BlogCategoryUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('category');

        return [
            'title'       => 'required|min:5|max:200',
            'slug'        => 'max:200|unique:blog_categories,slug,' . $id,
            'description' => 'nullable|string|min:3|max:500',
            'parent_id'   => 'required|integer|exists:blog_categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Введіть назву категорії',
            'title.min' => 'Назва категорії має містити щонайменше :min символів',
            'title.max' => 'Назва категорії не може перевищувати :max символів',

            'slug.max' => 'Слаг не може перевищувати :max символів',
            'slug.unique' => 'Категорія з таким слагом вже існує. Придумайте інший',

            'description.string' => 'Опис має бути текстовим',
            'description.min' => 'Опис має містити щонайменше :min символів',
            'description.max' => 'Опис не може перевищувати :max символів',

            'parent_id.required' => 'Оберіть батьківську категорію',
            'parent_id.integer' => 'ID категорії має бути числом',
            'parent_id.exists' => 'Обраної батьківської категорії не існує',
        ];
    }
}
