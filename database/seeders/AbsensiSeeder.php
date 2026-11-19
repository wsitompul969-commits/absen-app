<?php

namespace Database\Seeders;

use App\Models\Absensi;
use App\Models\Karyawan;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AbsensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $karyawans = Karyawan::query()->limit(3)->get();

        foreach ($karyawans as $index => $karyawan) {
            Absensi::firstOrCreate(
                [
                    'karyawan_id' => $karyawan->id,
                    'tanggal' => Carbon::today()->subDays($index),
                ],
                [
                    'waktu_masuk' => Carbon::today()->subDays($index)->setTime(8, 15),
                    'waktu_pulang' => Carbon::today()->subDays($index)->setTime(17, 0),
                    'status' => $index === 0 ? 'Hadir' : 'Izin',
                ],
            );
        }
    }
}
