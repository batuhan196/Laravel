<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        $query = Loan::with(['user', 'book']);

        if ($request->filled('status')) {
            if ($request->status === 'overdue') {
                $query->where('status', 'active')->where('due_date', '<', now());
            } else {
                $query->where('status', $request->status);
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('student_no', 'like', "%{$search}%");
            })->orWhereHas('book', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            });
        }

        $loans = $query->latest()->paginate(15);
        return view('loans.index', compact('loans'));
    }

    public function create()
    {
        $students = User::where('role', 'student')->get();
        $books = Book::where('available', '>', 0)->get();
        return view('loans.create', compact('students', 'books'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'due_date' => 'required|date|after:today',
            'notes' => 'nullable|string|max:500',
        ], [
            'user_id.required' => 'Öğrenci seçimi zorunludur.',
            'book_id.required' => 'Kitap seçimi zorunludur.',
            'due_date.required' => 'İade tarihi zorunludur.',
            'due_date.after' => 'İade tarihi bugünden sonra olmalıdır.',
        ]);

        $book = Book::findOrFail($request->book_id);

        if ($book->available <= 0) {
            return redirect()->back()->with('error', 'Bu kitap şu anda mevcut değil!');
        }

        Loan::create([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'loan_date' => now(),
            'due_date' => $request->due_date,
            'status' => 'active',
            'notes' => $request->notes,
        ]);

        $book->decrement('available');

        return redirect()->route('loans.index')->with('success', 'Kitap başarıyla ödünç verildi!');
    }

    public function returnBook($id)
    {
        $loan = Loan::findOrFail($id);
        $loan->update([
            'return_date' => now(),
            'status' => 'returned',
        ]);

        $loan->book->increment('available');

        return redirect()->route('loans.index')->with('success', 'Kitap başarıyla iade alındı!');
    }

    public function myLoans()
    {
        $user = auth()->user();
        $activeLoans = $user->loans()->with('book')->where('status', 'active')->get();
        $history = $user->loans()->with('book')->where('status', 'returned')->latest()->paginate(10);

        return view('loans.my-loans', compact('activeLoans', 'history'));
    }

    public function destroy(Loan $loan)
    {
        if ($loan->status === 'active') {
            $loan->book->increment('available');
        }
        $loan->delete();
        return redirect()->route('loans.index')->with('success', 'Ödünç kaydı silindi!');
    }
}
