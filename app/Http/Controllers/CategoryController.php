<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('books')->paginate(15);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:50',
        ], [
            'name.required' => 'Kategori adı zorunludur.',
            'name.unique' => 'Bu kategori adı zaten mevcut.',
        ]);

        Category::create($request->only('name', 'description', 'icon'));

        return redirect()->route('categories.index')->with('success', 'Kategori başarıyla eklendi!');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:50',
        ]);

        $category->update($request->only('name', 'description', 'icon'));

        return redirect()->route('categories.index')->with('success', 'Kategori başarıyla güncellendi!');
    }

    public function destroy(Category $category)
    {
        if ($category->books()->count() > 0) {
            return redirect()->route('categories.index')->with('error', 'Bu kategoriye ait kitaplar bulunduğu için silinemez!');
        }

        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kategori başarıyla silindi!');
    }
}
