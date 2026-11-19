<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Absensi</title>
        <style>
            body { margin: 0; font-family: Arial, sans-serif; background: #f1f5f9; color: #0f172a; }
            * { box-sizing: border-box; }
            a { text-decoration: none; }
            .container { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 24px; }
            .card { width: min(100%, 900px); background: #fff; border-radius: 28px; box-shadow: 0 10px 30px rgba(15, 23, 42, 0.1); padding: 32px; }
            .title { text-align: center; margin-bottom: 32px; }
            .label { font-size: 12px; font-weight: 700; letter-spacing: 0.2em; text-transform: uppercase; color: #059669; }
            h1 { margin: 12px 0 8px; font-size: 2.5rem; }
            .subtitle { color: #475569; margin: 0; }
            .grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 24px; }
            .panel { display: block; border-radius: 20px; padding: 24px; border: 2px solid; transition: 0.2s ease; }
            .panel.admin { background: #ecfdf5; border-color: #a7f3d0; }
            .panel.karyawan { background: #eff6ff; border-color: #bfdbfe; }
            .badge { display: inline-flex; width: 48px; height: 48px; align-items: center; justify-content: center; border-radius: 14px; font-size: 24px; color: #fff; }
            .admin .badge { background: #059669; }
            .karyawan .badge { background: #2563eb; }
            h2 { font-size: 2rem; margin: 18px 0 8px; }
            .panel p { color: #475569; line-height: 1.5; margin: 0; }
            .button { display: inline-block; margin-top: 20px; padding: 10px 16px; border-radius: 10px; color: #fff; font-weight: 700; font-size: 14px; }
            .admin .button { background: #059669; }
            .karyawan .button { background: #2563eb; }
            @media (max-width: 640px) { .grid { grid-template-columns: 1fr; } .card { padding: 20px; } h1 { font-size: 2rem; } }
        </style>
    </head>
    <body>
        <div class="mx-auto flex min-h-screen max-w-5xl items-center justify-center px-4">
            <div class="w-full rounded-3xl bg-white p-8 shadow-xl">
                <div class="mb-8 text-center">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-emerald-600">Absensi Karyawan</p>
                    <h1 class="mt-3 text-4xl font-bold">Login</h1>
                    <p class="mt-2 text-slate-600">Pilih akses sesuai peran Anda.</p>
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <a href="/admin/login" class="group rounded-2xl border border-emerald-200 bg-emerald-50 p-6 transition hover:border-emerald-400 hover:shadow-md">
                        <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-600 text-xl text-white">A</div>
                        <h2 class="text-2xl font-bold text-emerald-700">Admin</h2>
                        <p class="mt-2 text-sm text-slate-600">Masuk ke panel admin untuk mengelola departemen, karyawan, dan laporan absensi.</p>
                        <div class="mt-5 inline-flex rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white group-hover:bg-emerald-700">
                            Login Admin
                        </div>
                    </a>

                    <a href="/karyawan/login" class="group rounded-2xl border border-sky-200 bg-sky-50 p-6 transition hover:border-sky-400 hover:shadow-md">
                        <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-sky-600 text-xl text-white">K</div>
                        <h2 class="text-2xl font-bold text-sky-700">Karyawan</h2>
                        <p class="mt-2 text-sm text-slate-600">Masuk ke dashboard karyawan untuk melihat status presensi dan data diri.</p>
                        <div class="mt-5 inline-flex rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white group-hover:bg-sky-700">
                            Login Karyawan
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>
