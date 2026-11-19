<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Presensi Karyawan</title>
        <style>
            body { margin: 0; font-family: Arial, sans-serif; background: #f1f5f9; color: #0f172a; }
            * { box-sizing: border-box; }
            a, button, input, select, textarea { font: inherit; }
            .wrap { max-width: 960px; margin: 0 auto; padding: 48px 16px; }
            .card { background: #fff; border-radius: 24px; padding: 32px; box-shadow: 0 10px 30px rgba(15,23,42,0.08); }
            .header { margin-bottom: 24px; }
            .header p { color: #059669; text-transform: uppercase; letter-spacing: 0.18em; font-size: 12px; font-weight: 700; }
            h1 { margin: 12px 0 8px; font-size: 2.3rem; }
            .alert, .errors { border-radius: 12px; padding: 12px 14px; margin-bottom: 18px; }
            .alert { background: #ecfdf5; border: 1px solid #bbf7d0; color: #166534; }
            .errors { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }
            form { display: grid; gap: 18px; }
            .row { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 18px; }
            label { display: block; margin-bottom: 8px; font-weight: 600; }
            input, select, textarea { width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 12px; }
            textarea { min-height: 100px; resize: vertical; }
            button { width: 100%; border: none; border-radius: 12px; padding: 14px 16px; background: #059669; color: white; font-weight: 700; cursor: pointer; }
            @media (max-width: 640px) { .row { grid-template-columns: 1fr; } }
        </style>
    </head>
    <body>
        <div class="mx-auto max-w-3xl px-4 py-12">
            <div class="rounded-2xl bg-white p-8 shadow-md">
                <div class="mb-8">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-emerald-600">Absensi App</p>
                    <h1 class="mt-2 text-3xl font-bold">Presensi Karyawan</h1>
                    <p class="mt-2 text-sm text-slate-600">Catat kehadiran pegawai untuk hari ini.</p>
                </div>

                @if (session('success'))
                    <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 p-3 text-sm text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('presensi.store') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="karyawan_id" class="mb-2 block text-sm font-medium">Pilih Karyawan</label>
                        <select id="karyawan_id" name="karyawan_id" class="w-full rounded-xl border border-slate-300 px-3 py-2 focus:border-emerald-500 focus:outline-none" required>
                            <option value="">-- Pilih karyawan --</option>
                            @foreach ($karyawans as $karyawan)
                                <option value="{{ $karyawan->id }}">
                                    {{ $karyawan->nama_karyawan }} - {{ $karyawan->team?->nama_team ?? 'Belum diassign' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label for="tanggal" class="mb-2 block text-sm font-medium">Tanggal</label>
                            <input id="tanggal" type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full rounded-xl border border-slate-300 px-3 py-2 focus:border-emerald-500 focus:outline-none">
                        </div>

                        <div>
                            <label for="status" class="mb-2 block text-sm font-medium">Status</label>
                            <select id="status" name="status" class="w-full rounded-xl border border-slate-300 px-3 py-2 focus:border-emerald-500 focus:outline-none" required>
                                <option value="Hadir">Hadir</option>
                                <option value="Izin">Izin</option>
                                <option value="Sakit">Sakit</option>
                                <option value="Alpha">Alpha</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label for="waktu_masuk" class="mb-2 block text-sm font-medium">Waktu Masuk</label>
                            <input id="waktu_masuk" type="datetime-local" name="waktu_masuk" class="w-full rounded-xl border border-slate-300 px-3 py-2 focus:border-emerald-500 focus:outline-none">
                        </div>

                        <div>
                            <label for="waktu_pulang" class="mb-2 block text-sm font-medium">Waktu Pulang</label>
                            <input id="waktu_pulang" type="datetime-local" name="waktu_pulang" class="w-full rounded-xl border border-slate-300 px-3 py-2 focus:border-emerald-500 focus:outline-none">
                        </div>
                    </div>

                    <div>
                        <label for="keterangan_lembur" class="mb-2 block text-sm font-medium">Keterangan Lembur</label>
                        <textarea id="keterangan_lembur" name="keterangan_lembur" rows="3" class="w-full rounded-xl border border-slate-300 px-3 py-2 focus:border-emerald-500 focus:outline-none" placeholder="Opsional"></textarea>
                    </div>

                    <button type="submit" class="w-full rounded-xl bg-emerald-600 px-4 py-3 font-semibold text-white transition hover:bg-emerald-700">
                        Simpan Presensi
                    </button>
                </form>
            </div>
        </div>
    </body>
</html>
