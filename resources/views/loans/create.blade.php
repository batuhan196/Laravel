@extends('layouts.app')
@section('title', 'Kitap Ödünç Ver')
@section('content')
<div class="page-header">
    <div><h1>📤 Kitap Ödünç Ver</h1></div>
    <a href="{{ route('loans.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Geri</a>
</div>
<div class="card" style="max-width:600px">
    <form method="POST" action="{{ route('loans.store') }}">
        @csrf
        <div class="form-group">
            <label class="form-label">Öğrenci *</label>
            <select name="user_id" class="form-select" required>
                <option value="">Öğrenci Seçiniz...</option>
                @foreach($students as $s)
                <option value="{{ $s->id }}" {{ old('user_id') == $s->id ? 'selected' : '' }}>{{ $s->name }} ({{ $s->student_no ?? $s->email }})</option>
                @endforeach
            </select>
            @error('user_id')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Kitap *</label>
            <select name="book_id" class="form-select" required>
                <option value="">Kitap Seçiniz...</option>
                @foreach($books as $book)
                <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>{{ $book->title }} ({{ $book->available }} mevcut)</option>
                @endforeach
            </select>
            @error('book_id')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">İade Tarihi *</label>
            <input type="date" name="due_date" class="form-input" value="{{ old('due_date', now()->addDays(14)->format('Y-m-d')) }}" required>
            @error('due_date')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Notlar</label>
            <textarea name="notes" class="form-input" rows="2">{{ old('notes') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-hand-holding"></i> Ödünç Ver</button>
    </form>
</div>
@endsection
