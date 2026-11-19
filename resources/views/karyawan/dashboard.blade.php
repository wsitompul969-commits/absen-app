<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard Karyawan</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-slate-100 text-slate-800">
        <div class="mx-auto max-w-4xl px-4 py-10">
            <div class="mb-6 flex items-center justify-between rounded-2xl bg-white p-6 shadow-sm">
                <div>
                    <p class="text-sm uppercase tracking-[0.2em] text-emerald-600">Karyawan</p>
                    <h1 class="mt-2 text-3xl font-bold">Halo, {{ $karyawan->nama_karyawan }}</h1>
                </div>
                <form method="POST" action="{{ route('karyawan.logout') }}">
                    @csrf
                    <button type="submit" class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-medium hover:bg-slate-50">
                        Keluar
                    </button>
                </form>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div class="rounded-2xl bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Data Karyawan</p>
                    <ul class="mt-4 space-y-2 text-sm">
                        <li><strong>Nama:</strong> {{ $karyawan->nama_karyawan }}</li>
                        <li><strong>Email:</strong> {{ $karyawan->email }}</li>
                        <li><strong>Jabatan:</strong> {{ $karyawan->jabatan }}</li>
                        <li><strong>Team:</strong> {{ $karyawan->team?->nama_team ?? 'Belum ditentukan' }}</li>
                    </ul>
                </div>

                <div class="rounded-2xl bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Status Hari Ini</p>
                    @if ($presensiHariIni)
                        <div class="mt-4 rounded-xl bg-emerald-50 p-4 text-emerald-700">
                            <p class="font-semibold">{{ $presensiHariIni->status }}</p>
                            <p class="mt-1 text-sm">Tanggal: {{ $presensiHariIni->tanggal->format('d M Y') }}</p>
                            @if ($presensiHariIni->waktu_masuk)
                                @php
                                    $jamMasukStandar = \Illuminate\Support\Carbon::parse($presensiHariIni->tanggal->toDateString() . ' 08:30:00');
                                    $menitTerlambat = $presensiHariIni->waktu_masuk->greaterThan($jamMasukStandar) ? $presensiHariIni->waktu_masuk->diffInMinutes($jamMasukStandar) : 0;
                                @endphp
                                <p class="mt-1 text-sm">Masuk: {{ $presensiHariIni->waktu_masuk->format('H:i') }}</p>
                                @if ($menitTerlambat > 0)
                                    <p class="mt-1 text-xs font-medium">Terlambat {{ floor($menitTerlambat / 60) }} jam {{ $menitTerlambat % 60 }} menit</p>
                                @endif
                            @endif
                            @if ($presensiHariIni->jam_lembur > 0)
                                <p class="mt-1 text-xs font-medium">Lembur {{ $presensiHariIni->jam_lembur }} jam</p>
                            @endif
                        </div>
                    @else
                        <div class="mt-4 rounded-xl bg-amber-50 p-4 text-amber-700">
                            <p class="font-semibold">Belum ada presensi hari ini.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-6 rounded-2xl bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Aksi cepat</p>
                <div class="mt-4 flex flex-wrap gap-3">
                    <a href="{{ route('presensi.index') }}" class="rounded-xl bg-emerald-600 px-4 py-2 font-medium text-white hover:bg-emerald-700">
                        Isi Presensi
                    </a>
                    <a href="{{ route('karyawan.dashboard') }}" class="rounded-xl border border-slate-300 px-4 py-2 font-medium hover:bg-slate-50">
                        Refresh Status
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>
