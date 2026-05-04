@php
    $kamarData = $kamar ?? $item ?? null;
    $kamarId = $kamarId ?? data_get($kamarData, 'id_kamar', data_get($kamarData, 'id'));
    $isEdit = !empty($kamarId);

    $hunianOptions = collect($hunians ?? [])->mapWithKeys(fn ($hunian) => [data_get($hunian, 'id_hunian') => data_get($hunian, 'nama_hunian')])->all();
    $statusOptions = [
        'Tersedia' => 'Tersedia',
        'Penuh' => 'Penuh',
        'Rusak' => 'Rusak',
    ];

    $safeRoute = static fn (string $name, string $fallback) => \Illuminate\Support\Facades\Route::has($name) ? route($name) : url($fallback);
    $safeRouteWithParam = static fn (string $name, $param, string $fallback) => \Illuminate\Support\Facades\Route::has($name) ? route($name, $param) : url($fallback);

    // TODO: Wire controller routes for store/update when ready.
    $formAction = $isEdit
        ? $safeRouteWithParam('admin.kamar.update', $kamarId, '#')
        : $safeRoute('admin.kamar.store', '#');

    $pageTitle = $isEdit ? 'Edit Kamar' : 'Tambah Kamar';
@endphp

<x-admin-layout :title="$pageTitle" :page-title="$pageTitle" active="kamar">
    <div class="space-y-6">
        <x-admin.search-bar :placeholder="$pageTitle">
            <x-admin.action-button :href="$safeRoute('admin.kamar.index', '/admin/kamar')" variant="secondary" icon="bi-arrow-left">Kembali</x-admin.action-button>
        </x-admin.search-bar>

        <x-admin.panel :title="$pageTitle" icon="bi-door-open">
            <form method="POST" action="{{ $formAction }}" class="space-y-4">
                @csrf
                @if ($isEdit)
                    @method('PUT')
                @endif

                <x-admin.select-field
                    label="Hunian"
                    name="hunian_id"
                    :options="$hunianOptions"
                    placeholder="Pilih hunian"
                    :value="old('hunian_id', data_get($kamarData, 'hunian_id'))"
                />

                <x-admin.form-field
                    label="Nomor Kamar"
                    name="nomor_kamar"
                    placeholder="Contoh: A-12"
                    :value="old('nomor_kamar', data_get($kamarData, 'nomor_kamar'))"
                />

                <x-admin.form-field
                    label="Lantai"
                    name="lantai"
                    type="number"
                    placeholder="Contoh: 2"
                    :value="old('lantai', data_get($kamarData, 'lantai'))"
                />

                <x-admin.form-field
                    label="Kapasitas"
                    name="kapasitas"
                    type="number"
                    placeholder="Contoh: 4"
                    :value="old('kapasitas', data_get($kamarData, 'kapasitas'))"
                />

                <x-admin.form-field
                    label="Terisi"
                    name="terisi"
                    type="number"
                    placeholder="Contoh: 2"
                    :value="old('terisi', data_get($kamarData, 'terisi'))"
                />

                <x-admin.form-field
                    label="Harga Sewa"
                    name="harga_sewa"
                    type="number"
                    placeholder="Contoh: 350000"
                    :value="old('harga_sewa', data_get($kamarData, 'harga_sewa'))"
                />

                <x-admin.select-field
                    label="Status"
                    name="status"
                    :options="$statusOptions"
                    placeholder="Pilih status"
                    :value="old('status', data_get($kamarData, 'status'))"
                />

                <div class="flex flex-col gap-3 pt-3 sm:flex-row sm:justify-end">
                    <x-admin.action-button :href="$safeRoute('admin.kamar.index', '/admin/kamar')" variant="secondary" icon="bi-x-lg">Batal</x-admin.action-button>
                    <x-admin.action-button type="submit" variant="dark" icon="bi-save">
                        {{ $isEdit ? 'Perbarui Kamar' : 'Simpan Kamar' }}
                    </x-admin.action-button>
                </div>
            </form>
        </x-admin.panel>
    </div>
</x-admin-layout>
