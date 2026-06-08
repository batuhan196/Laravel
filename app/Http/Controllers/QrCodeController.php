<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class QrCodeController extends Controller
{
    public function scan()
    {
        return view('qrcode.scanner');
    }

    public function show($id)
    {
        $book = Book::with(['category', 'loans' => function ($q) {
            $q->where('status', 'active');
        }])->findOrFail($id);

        $qrUrl = route('qr.show', $book->id);

        return view('qrcode.result', compact('book', 'qrUrl'));
    }
}
