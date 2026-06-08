<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|regex:/^[0-9\-]+$/|unique:books,isbn,' . $this->route('book'),
            'category_id' => 'required|exists:categories,id',
            'publisher' => 'nullable|string|max:255',
            'page_count' => 'nullable|integer|min:1',
            'quantity' => 'required|integer|min:1',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'description' => 'nullable|string|max:2000',
            'shelf_no' => 'nullable|string|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Kitap başlığı zorunludur.',
            'author.required' => 'Yazar adı zorunludur.',
            'isbn.required' => 'ISBN numarası zorunludur.',
            'isbn.unique' => 'Bu ISBN numarası zaten kayıtlı.',
            'isbn.regex' => 'ISBN numarası sadece rakam ve tire içerebilir.',
            'category_id.required' => 'Kategori seçimi zorunludur.',
            'category_id.exists' => 'Geçersiz kategori.',
            'page_count.integer' => 'Sayfa sayısı bir sayı olmalıdır.',
            'quantity.required' => 'Adet zorunludur.',
            'cover_image.image' => 'Kapak fotoğrafı bir resim dosyası olmalıdır.',
            'cover_image.max' => 'Kapak fotoğrafı en fazla 2MB olabilir.',
        ];
    }
}
