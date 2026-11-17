<?php

namespace App\Http\Controllers;

use App\Models\PotensiDesa;
use Illuminate\Http\Request;

class UmkmController extends Controller
{
    public function index(Request $request)
    {
        $query = PotensiDesa::query()->aktif();

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%")
                    ->orWhere('pemilik', 'like', "%{$search}%");
            });
        }

        $produks = $query->latest()->get();

        return view('User.lamanUMKM', compact('produks'));
    }

    public function show($identifier)
    {
        $produk = PotensiDesa::where('slug', $identifier)
            ->orWhere('id', is_numeric($identifier) ? (int) $identifier : 0)
            ->firstOrFail();

        return view('User.detailUMKM', compact('produk'));
    }
}
