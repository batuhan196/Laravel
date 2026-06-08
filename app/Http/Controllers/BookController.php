<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('category');

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('category_id')) {
            $query->byCategory($request->category_id);
        }

        if ($request->filled('availability')) {
            if ($request->availability === 'available') {
                $query->where('available', '>', 0);
            } elseif ($request->availability === 'unavailable') {
                $query->where('available', '<=', 0);
            }
        }

        $books = $query->latest()->paginate(15);
        $categories = Category::all();

        return view('books.index', compact('books', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('books.create', compact('categories'));
    }

    public function store(StoreBookRequest $request)
    {
        $data = $request->validated();
        $data['available'] = $data['quantity'];

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        $book = Book::create($data);

        // Generate QR Code
        $qrContent = route('qr.show', $book->id);
        $book->update(['qr_code' => $qrContent]);

        return redirect()->route('books.index')->with('success', 'Kitap başarıyla eklendi!');
    }

    public function show(Book $book)
    {
        $book->load(['category', 'loans.user']);
        $qrUrl = route('qr.show', $book->id);
        return view('books.show', compact('book', 'qrUrl'));
    }

    public function edit(Book $book)
    {
        $categories = Category::all();
        return view('books.edit', compact('book', 'categories'));
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        $data = $request->validated();

        if ($request->hasFile('cover_image')) {
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        $book->update($data);

        return redirect()->route('books.index')->with('success', 'Kitap başarıyla güncellendi!');
    }

    public function destroy(Book $book)
    {
        $book->delete(); // Soft delete
        return redirect()->route('books.index')->with('success', 'Kitap arşive taşındı!');
    }

    public function trashed()
    {
        $books = Book::onlyTrashed()->with('category')->paginate(15);
        return view('books.trashed', compact('books'));
    }

    public function restore($id)
    {
        $book = Book::onlyTrashed()->findOrFail($id);
        $book->restore();
        return redirect()->route('books.trashed')->with('success', 'Kitap başarıyla geri yüklendi!');
    }

    public function forceDelete($id)
    {
        $book = Book::onlyTrashed()->findOrFail($id);
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }
        $book->forceDelete();
        return redirect()->route('books.trashed')->with('success', 'Kitap kalıcı olarak silindi!');
    }

    public function catalog(Request $request)
    {
        $query = Book::with('category')->where('available', '>', 0);

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('category_id')) {
            $query->byCategory($request->category_id);
        }

        $books = $query->latest()->paginate(12);
        $categories = Category::all();

        return view('books.catalog', compact('books', 'categories'));
    }
}
