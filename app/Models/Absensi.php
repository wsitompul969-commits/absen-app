<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'karyawan_id',
        'tanggal',
        'waktu_masuk',
        'waktu_pulang',
        'status',
        'foto_masuk',
        'foto_pulang',
        'lembur_jam',
        'keterangan_lembur',
    ];

    protected $appends = ['jam_lembur'];

    protected $casts = [
        'tanggal' => 'date',
        'waktu_masuk' => 'datetime',
        'waktu_pulang' => 'datetime',
    ];

    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function getJamLemburAttribute(): float
    {
        if (! $this->waktu_pulang) {
            return (float) ($this->lembur_jam ?? 0);
        }

        $tanggal = $this->tanggal instanceof Carbon ? $this->tanggal : Carbon::parse($this->tanggal ?? now()->toDateString());
        $batasLembur = $tanggal->copy()->setTime(17, 0, 0);
        $selisihMenit = max(0, (int) (($this->waktu_pulang->getTimestamp() - $batasLembur->getTimestamp()) / 60));

        if ($selisihMenit <= 0) {
            return (float) ($this->lembur_jam ?? 0);
        }

        return round((float) ($selisihMenit / 60), 2);
    }

    public function applyAutomaticValidation(): void
    {
        $tanggal = $this->tanggal instanceof Carbon ? $this->tanggal : Carbon::parse($this->tanggal ?? now()->toDateString());

        if ($this->status === 'Hadir' && $this->waktu_masuk) {
            $jamMasukStandar = $tanggal->copy()->setTime(8, 30, 0);

            if ($this->waktu_masuk->greaterThan($jamMasukStandar)) {
                $menitTerlambat = max(0, (int) (($this->waktu_masuk->getTimestamp() - $jamMasukStandar->getTimestamp()) / 60));
                $keterangan = $this->keterangan_lembur ?? '';

                if (! str_contains($keterangan, 'Terlambat')) {
                    $this->keterangan_lembur = trim($keterangan . ($keterangan !== '' ? '; ' : '') . 'Terlambat ' . $this->formatDuration($menitTerlambat));
                }
            }
        }

        if ($this->waktu_pulang) {
            $batasLembur = $tanggal->copy()->setTime(17, 0, 0);

            if ($this->waktu_pulang->greaterThan($batasLembur)) {
                $this->lembur_jam = round(max(0, (int) (($this->waktu_pulang->getTimestamp() - $batasLembur->getTimestamp()) / 60)) / 60, 2);
                $keterangan = $this->keterangan_lembur ?? '';

                if (! str_contains($keterangan, 'Lembur')) {
                    $this->keterangan_lembur = trim($keterangan . ($keterangan !== '' ? '; ' : '') . 'Lembur');
                }
            }
        }
    }

    protected function formatDuration(int $minutes): string
    {
        $hours = intdiv($minutes, 60);
        $mins = $minutes % 60;

        if ($hours > 0) {
            return sprintf('%d jam %d menit', $hours, $mins);
        }

        return sprintf('%d menit', $mins);
    }
}
