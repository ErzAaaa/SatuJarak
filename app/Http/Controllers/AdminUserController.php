<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    /**
     * Menampilkan daftar seluruh user dan status online/login mereka.
     */
    public function index(Request $request): View
    {
        $query = User::query()->latest();

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('no_hp', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->paginate(10)->withQueryString();

        // Cari user yang sedang aktif dalam 15 menit terakhir dari tabel sessions
        $onlineThreshold = time() - (15 * 60);
        $onlineUserIds = DB::table('sessions')
            ->whereNotNull('user_id')
            ->where('last_activity', '>=', $onlineThreshold)
            ->pluck('user_id')
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->toArray();

        // Ambil session terakhir untuk tiap user agar tahu IP & waktu terakhir aktif
        $recentSessions = DB::table('sessions')
            ->whereNotNull('user_id')
            ->orderBy('last_activity', 'desc')
            ->get()
            ->groupBy('user_id')
            ->map(fn ($group) => $group->first());

        $stats = [
            'total' => User::count(),
            'online' => count($onlineUserIds),
            'admin' => User::where('is_admin', true)->orWhere('role', 'Admin')->count(),
            'user' => User::where('role', 'User')->count(),
        ];

        return view('Admin.adminUserTable', compact('users', 'onlineUserIds', 'recentSessions', 'stats'));
    }

    /**
     * Menampilkan detail informasi akun user, riwayat sesi login, dan permohonan.
     */
    public function show(User $user): View
    {
        $user->load(['pengajuans' => function ($q) {
            $q->latest();
        }]);

        $onlineThreshold = time() - (15 * 60);

        // Ambil riwayat sesi dari tabel sessions
        $sessions = DB::table('sessions')
            ->where('user_id', $user->id)
            ->orderBy('last_activity', 'desc')
            ->limit(10)
            ->get();

        $latestSession = $sessions->first();
        $isOnline = $latestSession && $latestSession->last_activity >= $onlineThreshold;

        return view('Admin.adminUserDetail', compact('user', 'sessions', 'latestSession', 'isOnline'));
    }

    /**
     * Menampilkan detail akun admin yang sedang login (fallback route untuk /users/detail).
     */
    public function showSelf(): View
    {
        /** @var User $user */
        $user = Auth::user();

        return $this->show($user);
    }

    /**
     * Menyimpan user baru oleh Admin.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'role' => ['required', 'in:Admin,User,Editor'],
            'status' => ['required', 'in:Aktif,Nonaktif'],
            'no_hp' => ['nullable', 'string', 'max:20'],
        ]);

        $isAdmin = ($data['role'] === 'Admin');

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'status' => $data['status'],
            'no_hp' => $data['no_hp'] ?? null,
            'is_admin' => $isAdmin,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', "User {$data['name']} berhasil ditambahkan.");
    }

    /**
     * Memperbarui data profil, role, atau status user.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', 'in:Admin,User,Editor'],
            'status' => ['required', 'in:Aktif,Nonaktif'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        $updateData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'status' => $data['status'],
            'no_hp' => $data['no_hp'] ?? $user->no_hp,
            'is_admin' => ($data['role'] === 'Admin'),
        ];

        if (! empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        $user->update($updateData);

        return redirect()->back()
            ->with('success', "Data pengguna {$user->name} berhasil diperbarui.");
    }

    /**
     * Menghapus user dari sistem (tidak boleh menghapus akun sendiri).
     */
    public function destroy(User $user): RedirectResponse
    {
        if (Auth::id() === $user->id) {
            return redirect()->back()
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.');
        }

        $name = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', "Pengguna {$name} berhasil dihapus.");
    }
}
