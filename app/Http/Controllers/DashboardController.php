<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            $totalBooks = Book::count();
            $totalUsers = User::where('role', 'student')->count();
            $activeLoans = Loan::where('status', 'active')->count();
            $overdueLoans = Loan::where('status', 'active')->where('due_date', '<', now())->count();
            $totalCategories = Category::count();
            $recentLoans = Loan::with(['user', 'book'])->latest()->take(10)->get();
            $popularBooks = Book::withCount('loans')->orderByDesc('loans_count')->take(5)->get();
            $monthlyLoans = Loan::whereMonth('created_at', now()->month)->count();

            return view('dashboard.admin', compact(
                'totalBooks', 'totalUsers', 'activeLoans', 'overdueLoans',
                'totalCategories', 'recentLoans', 'popularBooks', 'monthlyLoans'
            ));
        }

        $myLoans = $user->loans()->with('book')->where('status', 'active')->get();
        $myOverdue = $user->loans()->with('book')->where('status', 'active')->where('due_date', '<', now())->get();
        $myHistory = $user->loans()->with('book')->where('status', 'returned')->latest()->take(5)->get();

        return view('dashboard.student', compact('myLoans', 'myOverdue', 'myHistory'));
    }
}
