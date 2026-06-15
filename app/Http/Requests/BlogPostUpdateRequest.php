<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogPostUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('post');

        return [
            'title' => 'required|min:5|max:200',
            'slug' => 'max:200|unique:blog_posts,slug,' . $id,
            'excerpt' => 'nullable|max:500',
            'content_raw' => 'required|string|min:5|max:10000',
            'category_id' => 'required|integer|exists:blog_categories,id',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Введіть заголовок статті',
            'title.min' => 'Заголовок має містити щонайменше :min символів',
            'title.max' => 'Заголовок не може перевищувати :max символів',

            'slug.max' => 'Слаг не може перевищувати :max символів',
            'slug.unique' => 'Стаття з таким слагом вже існує. Придумайте інший',

            'excerpt.max' => 'Короткий опис не може перевищувати :max символів',

            'content_raw.required' => 'Введіть текст статті',
            'content_raw.string' => 'Текст статті має бути рядком',
            'content_raw.min' => 'Текст статті має містити щонайменше :min символів',
            'content_raw.max' => 'Текст статті не може перевищувати :max символів',

            'category_id.required' => 'Оберіть категорію для статті',
            'category_id.integer' => 'ID категорії має бути числом',
            'category_id.exists' => 'Обраної категорії не існує',
        ];
    }
}
