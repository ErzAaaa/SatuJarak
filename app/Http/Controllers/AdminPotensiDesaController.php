<?php

namespace App\Http\Controllers;

use App\Models\PotensiDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPotensiDesaController extends Controller
{
    public function index(Request $request)
    {
        $query = PotensiDesa::query()->latest();

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('pemilik', 'like', "%{$search}%")
                    ->orWhere('lokasi', 'like', "%{$search}%")
                    ->orWhere('jenis_produk', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->status !== 'Semua Status') {
            $query->where('status', $request->status);
        }

        if ($request->filled('kategori') && $request->kategori !== 'Semua Kategori') {
            $query->where('kategori', $request->kategori);
        }

        $potensis = $query->paginate(10)->withQueryString();

        $stats = [
            'total' => PotensiDesa::count(),
            'pertanian' => PotensiDesa::where('kategori', 'Pertanian')->count(),
            'umkm' => PotensiDesa::where('kategori', 'UMKM')->count(),
            'wisata' => PotensiDesa::where('kategori', 'Wisata')->count(),
        ];

        return view('Admin.potensiDesa', compact('potensis', 'stats'));
    }

    public function show(PotensiDesa $potensi)
    {
        return view('Admin.detailPotensiDesa', compact('potensi'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:150'],
            'kategori' => ['nullable', 'string', 'max:100'],
            'jenis_produk' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'in:Aktif,Draft,Nonaktif'],
            'lokasi' => ['required', 'string', 'max:200'],
            'pemilik' => ['required', 'string', 'max:150'],
            'kontak' => ['nullable', 'string', 'max:50'],
            'harga_teks' => ['nullable', 'string', 'max:100'],
            'deskripsi' => ['required', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
        ]);

        if (empty($validated['kategori'])) {
            $validated['kategori'] = 'UMKM';
        }

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('potensi', 'public');
        }

        $created = PotensiDesa::create($validated);

        return redirect()->route('admin.potensi.index')
            ->with('success', "Potensi desa '{$created->nama}' berhasil ditambahkan!");
    }

    public function update(Request $request, PotensiDesa $potensi)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:150'],
            'kategori' => ['nullable', 'string', 'max:100'],
            'jenis_produk' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'in:Aktif,Draft,Nonaktif'],
            'lokasi' => ['required', 'string', 'max:200'],
            'pemilik' => ['required', 'string', 'max:150'],
            'kontak' => ['nullable', 'string', 'max:50'],
            'harga_teks' => ['nullable', 'string', 'max:100'],
            'deskripsi' => ['required', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
        ]);

        if ($request->hasFile('foto')) {
            if ($potensi->foto && Storage::disk('public')->exists($potensi->foto)) {
                Storage::disk('public')->delete($potensi->foto);
            }
            $validated['foto'] = $request->file('foto')->store('potensi', 'public');
        }

        $potensi->update($validated);

        return redirect()->route('admin.potensi.index')
            ->with('success', "Data potensi desa '{$potensi->nama}' berhasil diperbarui!");
    }

    public function destroy(PotensiDesa $potensi)
    {
        $nama = $potensi->nama;
        if ($potensi->foto && Storage::disk('public')->exists($potensi->foto)) {
            Storage::disk('public')->delete($potensi->foto);
        }

        $potensi->delete();

        return redirect()->route('admin.potensi.index')
            ->with('success', "Potensi desa '{$nama}' berhasil dihapus!");
    }
}
