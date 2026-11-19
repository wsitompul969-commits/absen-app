<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Karyawan</title>
        <style>
            body { margin: 0; font-family: Arial, sans-serif; background: #f1f5f9; color: #0f172a; }
            * { box-sizing: border-box; }
            input, button { font: inherit; }
            .wrap { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 24px; }
            .card { width: min(100%, 480px); background: #fff; border-radius: 24px; box-shadow: 0 14px 40px rgba(15,23,42,0.12); padding: 32px; }
            .brand { text-align: center; margin-bottom: 24px; }
            .brand p { margin: 0; color: #059669; font-size: 12px; letter-spacing: 0.2em; font-weight: 700; text-transform: uppercase; }
            h1 { margin: 14px 0 0; font-size: 2rem; }
            .alert { background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; border-radius: 12px; padding: 12px; margin-bottom: 16px; }
            form { display: grid; gap: 18px; }
            label { display: block; margin-bottom: 8px; font-weight: 600; }
            input { width: 100%; border: 1px solid #cbd5e1; border-radius: 12px; padding: 12px 14px; }
            input:focus { outline: 2px solid rgba(16, 185, 129, 0.2); border-color: #10b981; }
            .row { display: flex; justify-content: space-between; align-items: center; font-size: 14px; color: #475569; }
            button { width: 100%; border: none; border-radius: 12px; background: #059669; color: #fff; padding: 14px 16px; font-weight: 700; cursor: pointer; }
            a { color: #059669; text-decoration: none; }
        </style>
    </head>
    <body>
        <div class="mx-auto flex min-h-screen max-w-md items-center px-4">
            <div class="w-full rounded-2xl bg-white p-8 shadow-lg">
                <div class="mb-6 text-center">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-emerald-600">Absensi App</p>
                    <h1 class="mt-3 text-3xl font-bold">Login Karyawan</h1>
                </div>

                @if ($errors->any())
                    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('karyawan.authenticate') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="mb-2 block text-sm font-medium">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" class="w-full rounded-xl border border-slate-300 px-3 py-2 focus:border-emerald-500 focus:outline-none" required>
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-sm font-medium">Password</label>
                        <input id="password" type="password" name="password" class="w-full rounded-xl border border-slate-300 px-3 py-2 focus:border-emerald-500 focus:outline-none" required>
                    </div>

                    <div class="flex items-center justify-between text-sm text-slate-600">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="remember" value="1">
                            Ingat saya
                        </label>
                        <a href="{{ route('presensi.index') }}" class="text-emerald-600 hover:text-emerald-700">Presensi cepat</a>
                    </div>

                    <button type="submit" class="w-full rounded-xl bg-emerald-600 px-4 py-3 font-semibold text-white transition hover:bg-emerald-700">
                        Masuk
                    </button>
                </form>
            </div>
        </div>
    </body>
</html>
