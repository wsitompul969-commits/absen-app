<x-filament-panels::page>
    <div class="space-y-6">
        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-900">
            <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Filter Tanggal</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Lihat laporan absensi per hari.</p>
                </div>

                <div class="w-full max-w-xs">
                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">Tanggal</label>
                    <input
                        type="date"
                        wire:model.live="tanggal"
                        class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                    >
                </div>
            </div>
        </div>

        {{ $this->table }}
    </div>
</x-filament-panels::page>
