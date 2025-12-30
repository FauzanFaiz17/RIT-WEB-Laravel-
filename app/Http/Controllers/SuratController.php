<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SuratController extends Controller
{
    public function index()
    {
        $surats = Surat::latest()->get();
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
                $path = $file->store('public/arsip-surat');
                $surat->buktis()->create(['file_path' => $path]);
            }
        }

        return redirect()->route('surat.index')->with('success', 'Surat Berhasil Diperbarui');
    }

    public function destroy($id)
    {
        $surat = Surat::findOrFail($id);
        foreach($surat->buktis as $bukti){
            Storage::delete($bukti->file_path);
        }
        $surat->delete();
        return redirect()->route('surat.index')->with('success', 'Surat Dihapus');
    }
}