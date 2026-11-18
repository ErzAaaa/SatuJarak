<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminLayananController extends Controller
{
    /**
     * Tampilkan daftar layanan di panel admin.
     */
    public function index(Request $request)
    {
        $allLayanans = Layanan::query()->orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();

        $servicesData = $allLayanans->map(function ($item) {
            return [
                'id' => $item->kode_layanan ?: ('LYN-' . str_pad($item->id, 3, '0', STR_PAD_LEFT)),
                'real_id' => $item->id,
                'icon' => $item->logo_url,
                'name' => $item->nama_layanan,
                'link' => $item->link_url ?: '#',
                'description' => $item->deskripsi ?: '',
                'date' => $item->created_at ? $item->created_at->translatedFormat('d F Y') : '-',
                'status' => $item->status ?: 'Aktif',
                'detail_url' => route('admin.layanan.show', $item->id),
            ];
        });

        $stats = [
            'total' => $allLayanans->count(),
            'aktif' => $allLayanans->where('status', 'Aktif')->count(),
            'nonaktif' => $allLayanans->where('status', '!=', 'Aktif')->count(),
        ];

        return view('Admin.manageLayanan', [
            'servicesData' => $servicesData,
            'stats' => $stats,
        ]);
    }

    /**
     * Tampilkan detail layanan tertentu.
     */
    public function show($id)
    {
        $layanan = Layanan::findOrFail($id);
        $pengajuans = Pengajuan::latest()->take(5)->get();

        return view('Admin.detailLayanan', compact('layanan', 'pengajuans'));
    }

    /**
     * Simpan layanan baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_layanan' => ['nullable', 'string', 'max:50', 'unique:layanans,kode_layanan'],
            'nama_layanan' => ['required', 'string', 'max:150'],
            'kategori' => ['nullable', 'string', 'max:50'],
            'link_url' => ['nullable', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'max:50'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048'],
        ]);

        if (empty($validated['kode_layanan'])) {
            $nextId = (Layanan::max('id') ?? 0) + 1;
            $validated['kode_layanan'] = 'LYN-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);
        }

        if (empty($validated['status'])) {
            $validated['status'] = 'Aktif';
        }

        if (empty($validated['kategori'])) {
            $validated['kategori'] = 'masyarakat';
        }

        if (empty($validated['kode_layanan'])) {
            unset($validated['kode_layanan']);
        }

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('layanan', 'public');
        }

        $nextUrutan = (Layanan::max('urutan') ?? 0) + 1;
        $validated['urutan'] = $nextUrutan;

        Layanan::create($validated);

        return redirect()->route('admin.layanan.index')->with('success', 'Layanan baru berhasil ditambahkan.');
    }

    /**
     * Perbarui data layanan.
     */
    public function update(Request $request, $id)
    {
        $layanan = Layanan::findOrFail($id);

        $validated = $request->validate([
            'kode_layanan' => ['nullable', 'string', 'max:50', 'unique:layanans,kode_layanan,' . $layanan->id],
            'nama_layanan' => ['required', 'string', 'max:150'],
            'kategori' => ['nullable', 'string', 'max:50'],
            'status' => ['required', 'string', 'max:50'],
            'deskripsi' => ['nullable', 'string'],
            'link_url' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048'],
        ]);

        if (empty($validated['kode_layanan'])) {
            unset($validated['kode_layanan']);
        }

        if ($request->hasFile('logo')) {
            if ($layanan->logo && Storage::disk('public')->exists($layanan->logo)) {
                Storage::disk('public')->delete($layanan->logo);
            }
            $validated['logo'] = $request->file('logo')->store('layanan', 'public');
        } else {
            unset($validated['logo']);
        }

        $layanan->update($validated);

        return redirect()->route('admin.layanan.show', $layanan->id)->with('success', 'Data layanan berhasil diperbarui.');
    }

    /**
     * Toggle status aktif / non aktif layanan.
     */
    public function toggleStatus(Request $request, $id)
    {
        $layanan = Layanan::findOrFail($id);

        if ($request->filled('status')) {
            $layanan->status = $request->status;
        } else {
            $layanan->status = ($layanan->status === 'Aktif') ? 'Non Aktif' : 'Aktif';
        }

        $layanan->save();

        return redirect()->route('admin.layanan.show', $layanan->id)->with('success', 'Status layanan berhasil diubah menjadi ' . $layanan->status . '.');
    }

    /**
     * Hapus layanan dari database.
     */
    public function destroy($id)
    {
        $layanan = Layanan::findOrFail($id);

        if ($layanan->logo && Storage::disk('public')->exists($layanan->logo)) {
            Storage::disk('public')->delete($layanan->logo);
        }

        $layanan->delete();

        return redirect()->route('admin.layanan.index')->with('success', 'Layanan berhasil dihapus.');
    }
}
