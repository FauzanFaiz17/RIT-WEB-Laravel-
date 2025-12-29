<?php

namespace App\Http\Controllers;

use App\Models\InventarisBarang;
use App\Models\InventarisMutasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InventarisController extends Controller
{
    // --- BAGIAN BARANG (MASTER) ---
    public function indexBarang()
    {
        $barangs = InventarisBarang::with('buktis')->get();
        return view('inventaris.barang.index', compact('barangs'));
    }

    public function storeBarang(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required', 
            'jumlah' => 'required|integer|min:0',
            'terpakai' => 'required|integer|min:0|lte:jumlah',
            'bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = [
            'nama_barang' => $request->nama_barang,
            'terpakai' => $request->terpakai,
            'stok' => $request->jumlah - $request->terpakai,
            'lokasi' => $request->lokasi ?? null
        ];

        $barang = InventarisBarang::create($data);

        // Handle file upload menggunakan polymorphic relationship
        if ($request->hasFile('bukti')) {
            $path = $request->file('bukti')->store('bukti_inventaris', 'public');
            $barang->buktis()->create(['file_path' => $path]);
        }

        return back()->with('success', 'Barang Baru Ditambahkan');
    }

    public function updateBarang(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required',
            'jumlah' => 'required|integer|min:0',
            'terpakai' => 'required|integer|min:0|lte:jumlah',
            'bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $barang = InventarisBarang::findOrFail($id);
        
        $data = [
            'nama_barang' => $request->nama_barang,
            'terpakai' => $request->terpakai,
            'stok' => $request->jumlah - $request->terpakai,
            'lokasi' => $request->lokasi ?? $barang->lokasi
        ];

        $barang->update($data);

        // Handle file upload menggunakan polymorphic relationship
        if ($request->hasFile('bukti')) {
            // Hapus bukti lama jika ada
            foreach($barang->buktis as $bukti){
                Storage::disk('public')->delete($bukti->file_path);
                $bukti->delete();
            }
            // Simpan bukti baru
            $path = $request->file('bukti')->store('bukti_inventaris', 'public');
            $barang->buktis()->create(['file_path' => $path]);
        }

        return back()->with('success', 'Data Barang Diperbarui');
    }

    public function destroyBarang($id)
    {
        $barang = InventarisBarang::findOrFail($id);
        
        // Hapus bukti jika ada
        foreach($barang->buktis as $bukti){
            Storage::disk('public')->delete($bukti->file_path);
            $bukti->delete();
        }
        
        $barang->delete();
        return back()->with('success', 'Barang Dihapus');
    }
}