<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Pengajuan;
use App\Models\PotensiDesa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $statsPengajuan = [
            'total' => Pengajuan::count(),
            'menunggu' => Pengajuan::where('status', 'Menunggu Verifikasi')->count(),
            'disetujui' => Pengajuan::where('status', 'Selesai')->count(),
            'ditolak' => Pengajuan::where('status', 'Ditolak')->count(),
            'proses' => Pengajuan::where('status', 'Sedang Diproses')->count(),
        ];

        $counts = [
            'user' => User::count(),
            'pengajuan' => $statsPengajuan['total'],
            'layanan' => Layanan::count(),
            'potensi' => PotensiDesa::count(),
        ];

        // 5 User terbaru beserta status aktivitas login
        $recentUsers = User::latest()->take(5)->get()->map(function ($u) {
            $lastSession = DB::table('sessions')
                ->where('user_id', $u->id)
                ->orderByDesc('last_activity')
                ->first();

            $isOnline = $lastSession && ($lastSession->last_activity >= (time() - 900)); // 15 menit terakhir
            $lastActiveText = $lastSession
                ? Carbon::createFromTimestamp($lastSession->last_activity)->diffForHumans()
                : ($u->created_at ? $u->created_at->diffForHumans() : '-');

            return [
                'id' => $u->id,
                'name' => $u->name,
                'email' => $u->email,
                'role' => $u->role ?? ($u->is_admin ? 'Admin' : 'User'),
                'is_online' => $isOnline,
                'last_active' => $lastActiveText,
            ];
        });

        // Pengajuan per kategori/layanan
        $layananPopuler = Pengajuan::select('jenis_kegiatan as nama', DB::raw('count(*) as pengajuan'))
            ->whereNotNull('jenis_kegiatan')
            ->groupBy('jenis_kegiatan')
            ->orderByDesc('pengajuan')
            ->take(5)
            ->get();

        // Jika data pengajuan masih sedikit, gabungkan dengan daftar master layanan
        if ($layananPopuler->isEmpty()) {
            $layananPopuler = Layanan::take(4)->get()->map(function ($l) {
                return (object) [
                    'nama' => $l->nama,
                    'pengajuan' => Pengajuan::where('jenis_kegiatan', 'like', "%{$l->nama}%")->count(),
                ];
            });
        }

        return view('Admin.dashboardadmin', compact('statsPengajuan', 'counts', 'recentUsers', 'layananPopuler'));
    }
}
