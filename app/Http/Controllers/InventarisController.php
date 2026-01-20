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
    // BARANG 
    public function indexBarang(Request $request)
    {
        $query = InventarisBarang::with('buktis');

        // Filter Logic
        if ($request->filled('nama_barang')) {
            $query->where('nama_barang', 'like', '%' . $request->nama_barang . '%');
        }
        if ($request->filled('jumlah')) {
            $query->where('jumlah', $request->jumlah);
        }
        if ($request->filled('terpakai')) {
            $query->where('terpakai', $request->terpakai);
        }
        if ($request->filled('stok')) {
            $query->where('stok', $request->stok);
        }

        $barangs = $query->oldest()->paginate(10)->withQueryString();
        return view('inventaris.barang.index', compact('barangs'));
    }

    public function storeBarang(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required', 
            'jumlah' => 'required|integer|min:0',
            'terpakai' => 'required|integer|min:0|lte:jumlah',
            'bukti.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'nama_barang.required' => 'Nama barang wajib diisi.',
            'jumlah.required' => 'Jumlah barang wajib diisi.',
            'jumlah.integer' => 'Jumlah barang harus berupa angka.',
            'jumlah.min' => 'Jumlah barang tidak boleh negatif.',
            'terpakai.required' => 'Jumlah barang terpakai wajib diisi.',
            'terpakai.integer' => 'Jumlah terpakai harus berupa angka.',
            'terpakai.min' => 'Jumlah terpakai tidak boleh negatif.',
            'terpakai.lte' => 'Jumlah terpakai tidak boleh melebihi total jumlah barang.',
            'bukti.*.image' => 'File bukti harus berupa gambar.',
            'bukti.*.mimes' => 'Format file yang diperbolehkan: jpeg, png, jpg, gif.',
            'bukti.*.max' => 'Ukuran maksimal file adalah 2MB.'
        ]);

        $data = [
            'nama_barang' => $request->nama_barang,
            'terpakai' => $request->terpakai,
            'stok' => $request->jumlah - $request->terpakai,
            'lokasi' => $request->lokasi ?? null
        ];

        $barang = InventarisBarang::create($data);

        // Handle file upload pake array
        if ($request->hasFile('bukti')) {
            foreach($request->file('bukti') as $file) {
                $path = $file->store('bukti_inventaris', 'public');
                $barang->buktis()->create(['file_path' => $path]);
            }
        }

        return back()->with('success', 'Barang Baru Ditambahkan');
    }

    public function updateBarang(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required',
            'jumlah' => 'required|integer|min:0',
            'terpakai' => 'required|integer|min:0|lte:jumlah',
            'bukti.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'nama_barang.required' => 'Nama barang wajib diisi.',
            'jumlah.required' => 'Jumlah barang wajib diisi.',
            'jumlah.integer' => 'Jumlah barang harus berupa angka.',
            'jumlah.min' => 'Jumlah barang tidak boleh negatif.',
            'terpakai.required' => 'Jumlah barang terpakai wajib diisi.',
            'terpakai.integer' => 'Jumlah terpakai harus berupa angka.',
            'terpakai.min' => 'Jumlah terpakai tidak boleh negatif.',
            'terpakai.lte' => 'Jumlah terpakai tidak boleh melebihi total jumlah barang.',
            'bukti.*.image' => 'File bukti harus berupa gambar.',
            'bukti.*.mimes' => 'Format file yang diperbolehkan: jpeg, png, jpg, gif.',
            'bukti.*.max' => 'Ukuran maksimal file adalah 2MB.'
        ]);
        
        $barang = InventarisBarang::findOrFail($id);
        
        $data = [
            'nama_barang' => $request->nama_barang,
            'terpakai' => $request->terpakai,
            'stok' => $request->jumlah - $request->terpakai,
            'lokasi' => $request->lokasi ?? $barang->lokasi
        ];

        $barang->update($data);

        // Handle file upload yg udah ada
        if ($request->hasFile('bukti')) {
            foreach($request->file('bukti') as $file) {
                $path = $file->store('bukti_inventaris', 'public');
                $barang->buktis()->create(['file_path' => $path]);
            }
        }

        return back()->with('success', 'Data Barang Diperbarui');
    }

    public function destroyBarang($id)
    {
        $barang = InventarisBarang::findOrFail($id);
        
        // Hapus bukti kalo ada
        foreach($barang->buktis as $bukti){
            Storage::disk('public')->delete($bukti->file_path);
            $bukti->delete();
        }
        
        $barang->delete();
        return back()->with('success', 'Barang Dihapus');
    }
}