<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = trim($request->input('search'));

            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('no_telp', 'like', "%{$search}%");
            });
        }

        if (in_array($request->input('role'), ['admin', 'pelanggan'], true)) {
            $query->where('role', $request->input('role'));
        }

        $users = $query->orderByDesc('id_user')
            ->paginate(10)
            ->withQueryString();

        $totalUsers = User::count();
        $totalAdmin = User::where('role', 'admin')->count();
        $totalPelanggan = User::where('role', 'pelanggan')->count();

        return view('admin.user.index', compact(
            'users',
            'totalUsers',
            'totalAdmin',
            'totalPelanggan'
        ));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:user,email'],
            'no_telp' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in(['admin', 'pelanggan'])],
        ]);

        User::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'no_telp' => $validated['no_telp'] ?? null,
            'password' => $validated['password'],
            'role' => $validated['role'],
            'created_at' => now(),
        ]);

        return redirect()
            ->route('admin.user.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('user', 'email')->ignore($user->id_user, 'id_user'),
            ],
            'no_telp' => ['nullable', 'string', 'max:20'],
            'role' => ['required', Rule::in(['admin', 'pelanggan'])],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        // Jangan biarkan admin mengubah role akun sendiri.
        if ((string) $user->id_user === (string) Auth::id()) {
            $validated['role'] = $user->role;
        }

        $data = [
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'no_telp' => $validated['no_telp'] ?? null,
            'role' => $validated['role'],
        ];

        // Password hanya diganti jika kolom diisi.
        if (!empty($validated['password'])) {
            $data['password'] = $validated['password'];
        }

        $user->update($data);

        return redirect()
            ->route('admin.user.index')
            ->with('success', 'Data user berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        // Mencegah akun yang sedang digunakan menghapus dirinya sendiri.
        if ((string) $user->id_user === (string) Auth::id()) {
            return redirect()
                ->route('admin.user.index')
                ->with('error', 'Kamu tidak bisa menghapus akun yang sedang digunakan.');
        }

        // Jangan menghapus admin terakhir.
        if ($user->role === 'admin' &&
            User::where('role', 'admin')->count() <= 1) {
            return redirect()
                ->route('admin.user.index')
                ->with('error', 'Admin terakhir tidak boleh dihapus.');
        }

        $user->delete();

        return redirect()
            ->route('admin.user.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
