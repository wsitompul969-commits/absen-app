<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class PresensiController extends Controller
{
    public function index()
    {
        $karyawans = Karyawan::query()
            ->with('team.departemen')
            ->orderBy('nama_karyawan')
            ->get();

        return view('presensi.index', compact('karyawans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'karyawan_id' => ['required', 'exists:karyawans,id'],
            'tanggal' => ['nullable', 'date'],
            'status' => ['required', 'in:Hadir,Izin,Sakit,Alpha'],
            'waktu_masuk' => ['nullable', 'date_format:Y-m-d\TH:i'],
            'waktu_pulang' => ['nullable', 'date_format:Y-m-d\TH:i', 'after_or_equal:waktu_masuk'],
            'keterangan_lembur' => ['nullable', 'string', 'max:255'],
        ]);

        $tanggal = $validated['tanggal'] ?? now()->toDateString();

        $presensi = Absensi::firstOrNew([
            'karyawan_id' => $validated['karyawan_id'],
            'tanggal' => $tanggal,
        ]);

        $presensi->status = $validated['status'];
        $presensi->waktu_masuk = $validated['waktu_masuk'] ? \Carbon\Carbon::parse($validated['waktu_masuk']) : ($presensi->waktu_masuk ?? now());
        $presensi->waktu_pulang = $validated['waktu_pulang'] ? \Carbon\Carbon::parse($validated['waktu_pulang']) : $presensi->waktu_pulang;
        $presensi->keterangan_lembur = $validated['keterangan_lembur'] ?? $presensi->keterangan_lembur;
        $presensi->applyAutomaticValidation();
        $presensi->save();

        return back()->with('success', 'Presensi berhasil disimpan.');
    }
}
