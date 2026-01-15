<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SuratController extends Controller
{
    public function index(Request $request)
    {
        $query = Surat::query();

        // Filter Logic
        if ($request->filled('tipe_surat')) {
            $query->where('tipe_surat', $request->tipe_surat);
        }
        if ($request->filled('nomor_surat')) {
            $query->where('nomor_surat', 'like', '%' . $request->nomor_surat . '%');
        }
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }
        if ($request->filled('perihal')) {
            $query->where('perihal', 'like', '%' . $request->perihal . '%');
        }
        if ($request->filled('asal_tujuan')) {
            $query->where('asal_tujuan', 'like', '%' . $request->asal_tujuan . '%');
        }

        $surats = $query->orderBy('tanggal', 'asc')->paginate(10)->withQueryString();
        return view('surat.index', compact('surats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_surat' => 'required',
            'tipe_surat' => 'required|in:1,2',
            'perihal' => 'required',
            'asal_tujuan' => 'required',
            'tanggal' => 'required|date',
            'file_surat.*' => 'nullable|mimes:pdf,jpg,png|max:2048'
        ], [
            'nomor_surat.required' => 'Nomor surat wajib diisi.',
            'tipe_surat.required' => 'Tipe surat wajib dipilih.',
            'tipe_surat.in' => 'Tipe surat tidak valid.',
            'perihal.required' => 'Perihal surat wajib diisi.',
            'asal_tujuan.required' => 'Asal/Tujuan surat wajib diisi.',
            'tanggal.required' => 'Tanggal surat wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'file_surat.*.mimes' => 'Format file yang diperbolehkan: pdf, jpg, png.',
            'file_surat.*.max' => 'Ukuran maksimal file adalah 2MB.'
        ]);

      
        $surat = Surat::create([
            'nomor_surat' => $request->nomor_surat,
            'tipe_surat' => $request->tipe_surat,
            'perihal' => $request->perihal,
            'asal_tujuan' => $request->asal_tujuan,
            'tanggal' => $request->tanggal,
            'ringkasan' => $request->ringkasan
        ]);

        // Handle Polymorphic Upload
        if ($request->hasFile('file_surat')) {
            $request->validate(['file_surat.*' => 'nullable|mimes:pdf,jpg,png|max:2048']);
            foreach ($request->file('file_surat') as $file) {
                $path = $file->store('arsip-surat', 'public');
                $surat->buktis()->create(['file_path' => $path]);
            }
        }

        return redirect()->route('surat.index')->with('success', 'Surat Berhasil Diarsipkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor_surat' => 'required',
            'tipe_surat' => 'required|in:1,2',
            'perihal' => 'required',
            'asal_tujuan' => 'required',
            'tanggal' => 'required|date'
        ], [
            'nomor_surat.required' => 'Nomor surat wajib diisi.',
            'tipe_surat.required' => 'Tipe surat wajib dipilih.',
            'tipe_surat.in' => 'Tipe surat tidak valid.',
            'perihal.required' => 'Perihal surat wajib diisi.',
            'asal_tujuan.required' => 'Asal/Tujuan surat wajib diisi.',
            'tanggal.required' => 'Tanggal surat wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
        ]);

        $surat = Surat::findOrFail($id);
        $surat->update([
            'nomor_surat' => $request->nomor_surat,
            'tipe_surat' => $request->tipe_surat,
            'perihal' => $request->perihal,
            'asal_tujuan' => $request->asal_tujuan,
            'tanggal' => $request->tanggal,
            'ringkasan' => $request->ringkasan
        ]);

        // Optional: Handle new file uploads (append)
        if ($request->hasFile('file_surat')) {
            $request->validate(['file_surat.*' => 'nullable|mimes:pdf,jpg,png|max:2048']);
            foreach ($request->file('file_surat') as $file) {
                $path = $file->store('arsip-surat', 'public');
                $surat->buktis()->create(['file_path' => $path]);
            }
        }

        return redirect()->route('surat.index')->with('success', 'Surat Berhasil Diperbarui');
    }

    public function destroy($id)
    {
        $surat = Surat::findOrFail($id);
        foreach($surat->buktis as $bukti){
            Storage::disk('public')->delete($bukti->file_path);
        }
        $surat->delete();
        return redirect()->route('surat.index')->with('success', 'Surat Dihapus');
    }
}