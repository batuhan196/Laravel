<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('student_no', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(15);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,student',
            'student_no' => 'nullable|unique:users',
            'class' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:20',
        ], [
            'name.required' => 'Ad soyad zorunludur.',
            'email.required' => 'E-posta zorunludur.',
            'email.unique' => 'Bu e-posta adresi zaten kayıtlı.',
            'password.required' => 'Şifre zorunludur.',
            'password.min' => 'Şifre en az 6 karakter olmalıdır.',
            'student_no.unique' => 'Bu öğrenci numarası zaten kayıtlı.',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'student_no' => $request->student_no,
            'class' => $request->class,
            'phone' => $request->phone,
        ]);

        return redirect()->route('users.index')->with('success', 'Kullanıcı başarıyla oluşturuldu!');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,student',
            'student_no' => 'nullable|unique:users,student_no,' . $user->id,
            'class' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:20',
        ]);

        $data = $request->only('name', 'email', 'role', 'student_no', 'class', 'phone');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Kullanıcı başarıyla güncellendi!');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')->with('error', 'Kendinizi silemezsiniz!');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Kullanıcı başarıyla silindi!');
    }
}
