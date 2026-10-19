<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    // MENAMPILKAN LOGIN
    public function showLogin()
    {
        return view('auth.login');
    }

    // MEMPROSES LOGIN DENGAN EMAIL
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email', 'max:100'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($credentials)) {
            return back()
                ->withErrors([
                    'email' => 'Email atau password salah.',
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        $user = Auth::user();

        // ADMIN MASUK KE DASHBOARD ADMIN
        if ($user->role === 'admin') {
            return redirect()
                ->route('admin.dashboard')
                ->with('success', 'Login admin berhasil!');
        }

        // PELANGGAN MASUK KE HALAMAN AKUN
        if ($user->role === 'pelanggan') {
            return redirect()
                ->route('account.profile')
                ->with('success', 'Login berhasil!');
        }

        // LOGOUT JIKA ROLE TIDAK VALID
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->withErrors([
                'email' => 'Role akun tidak valid.',
            ]);
    }

    // MENAMPILKAN REGISTRASI
    public function showRegister()
    {
        return view('auth.register');
    }

    // MEMPROSES REGISTRASI
    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('user', 'email'),
            ],
            'no_telp' => ['nullable', 'string', 'max:20'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8),
            ],
        ]);

        $user = User::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'no_telp' => $validated['no_telp'] ?? null,
            'password' => $validated['password'],
            'role' => 'pelanggan',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()
            ->route('account.profile')
            ->with(
                'success',
                'Registrasi berhasil! Selamat datang di ELECTROMART.'
            );
    }

    // MENAMPILKAN PROFIL
    public function profile()
    {
        return view('auth.profil', [
            'user' => Auth::user(),
        ]);
    }

    // MENAMPILKAN FORM EDIT PROFIL
    public function editProfile()
    {
        return view('auth.edit-profil', [
            'user' => Auth::user(),
        ]);
    }

    // MENYIMPAN EDIT PROFIL
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('user', 'email')->ignore(
                    $user->id_user,
                    'id_user'
                ),
            ],
            'no_telp' => ['nullable', 'string', 'max:20'],
        ]);

        $user->update($validated);

        return redirect()
            ->route('account.profile')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    // MENAMPILKAN FORM GANTI PASSWORD
    public function showChangePassword()
    {
        return view('auth.ganti-password');
    }

    // MEMVERIFIKASI PASSWORD LAMA DAN MENYIMPAN PASSWORD BARU
    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8),
            ],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $user = Auth::user();

        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()
                ->withErrors([
                    'current_password' => 'Password saat ini salah.',
                ]);
        }

        $user->password = $validated['password'];
        $user->save();

        return redirect()
            ->route('account.profile')
            ->with('success', 'Password berhasil diganti!');
    }

    // LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'Kamu berhasil logout.');
    }
}
