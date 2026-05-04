@php
    $hunianData = $hunian ?? $item ?? null;
    $hunianId = $hunianId ?? data_get($hunianData, 'id_hunian', data_get($hunianData, 'id'));
    $isEdit = !empty($hunianId);

    $safeRoute = static fn (string $name, string $fallback) => \Illuminate\Support\Facades\Route::has($name) ? route($name) : url($fallback);
    $safeRouteWithParam = static fn (string $name, $param, string $fallback) => \Illuminate\Support\Facades\Route::has($name) ? route($name, $param) : url($fallback);

    // TODO: Wire controller routes for store/update when ready.
    $formAction = $isEdit
        ? $safeRouteWithParam('admin.hunian.update', $hunianId, '#')
        : $safeRoute('admin.hunian.store', '#');

    $pageTitle = $isEdit ? 'Edit Hunian' : 'Tambah Hunian';
    $tipeOptions = [
        'Rusunawa' => 'Rusunawa',
        'Asrama' => 'Asrama',
        'Apartemen' => 'Apartemen',
    ];
    $statusOptions = [
        1 => 'Ya, khusus KIPK',
        0 => 'Tidak, hunian umum',
    ];
@endphp

<x-admin-layout :title="$pageTitle" :page-title="$pageTitle" active="hunian">
    <div class="space-y-6">
        <x-admin.search-bar :placeholder="$pageTitle">
            <x-admin.action-button :href="$safeRoute('admin.hunian.index', '/admin/hunian')" variant="secondary" icon="bi-arrow-left">Kembali</x-admin.action-button>
        </x-admin.search-bar>

        <x-admin.panel :title="$pageTitle" icon="bi-buildings">
            <form method="POST" action="{{ $formAction }}" class="space-y-5">
                @csrf
                @if ($isEdit)
                    @method('PUT')
                @endif

                <x-admin.form-field
                    label="Nama Hunian"
                    name="nama_hunian"
                    placeholder="Contoh: Rusunawa Unsri"
                    :value="old('nama_hunian', data_get($hunianData, 'nama_hunian'))"
                />

                <x-admin.select-field
                    label="Tipe Hunian"
                    name="tipe"
                    :options="$tipeOptions"
                    placeholder="Pilih tipe hunian"
                    :value="old('tipe', data_get($hunianData, 'tipe'))"
                />

                <div class="block">
                    <span class="text-sm font-semibold text-content-main">Lokasi</span>
                    <textarea
                        name="lokasi"
                        rows="4"
                        placeholder="Contoh: Jalan Kampus, Indralaya"
                        class="mt-2 w-full rounded-2xl border border-border-soft bg-bg-surface px-4 py-3 text-sm outline-none transition placeholder:text-content-sub/70 focus:border-brand focus:bg-bg-base focus:ring-4 focus:ring-brand-soft"
                    >{{ old('lokasi', data_get($hunianData, 'lokasi')) }}</textarea>
                    @error('lokasi')
                        <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="block">
                    <span class="text-sm font-semibold text-content-main">Deskripsi</span>
                    <textarea
                        name="deskripsi"
                        rows="5"
                        placeholder="Tulis deskripsi singkat hunian bila diperlukan"
                        class="mt-2 w-full rounded-2xl border border-border-soft bg-bg-surface px-4 py-3 text-sm outline-none transition placeholder:text-content-sub/70 focus:border-brand focus:bg-bg-base focus:ring-4 focus:ring-brand-soft"
                    >{{ old('deskripsi', data_get($hunianData, 'deskripsi')) }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <x-admin.select-field
                    label="Status KIPK"
                    name="khusus_kipk"
                    :options="$statusOptions"
                    placeholder="Pilih status hunian"
                    :value="old('khusus_kipk', data_get($hunianData, 'khusus_kipk') ? 1 : 0)"
                />

                <div class="flex flex-col gap-3 pt-2 sm:flex-row sm:justify-end">
                    <x-admin.action-button :href="$safeRoute('admin.hunian.index', '/admin/hunian')" variant="secondary" icon="bi-x-lg">Batal</x-admin.action-button>
                    <x-admin.action-button type="submit" variant="dark" icon="bi-save">
                        {{ $isEdit ? 'Perbarui Hunian' : 'Simpan Hunian' }}
                    </x-admin.action-button>
                </div>
            </form>
        </x-admin.panel>
    </div>
</x-admin-layout>
