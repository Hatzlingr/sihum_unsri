@php
    $mahasiswaData = $mahasiswa ?? $student ?? null;
    $mahasiswaId = $mahasiswaId ?? data_get($mahasiswaData, 'id_mahasiswa', data_get($mahasiswaData, 'id'));
    $isEdit = !empty($mahasiswaId);

    $safeRoute = static fn (string $name, string $fallback) => \Illuminate\Support\Facades\Route::has($name) ? route($name) : url($fallback);
    $safeRouteWithParam = static fn (string $name, $param, string $fallback) => \Illuminate\Support\Facades\Route::has($name) ? route($name, $param) : url($fallback);

    // TODO: Wire controller routes for store/update when ready.
    $formAction = $isEdit
        ? $safeRouteWithParam('admin.mahasiswa.update', $mahasiswaId, '#')
        : $safeRoute('admin.mahasiswa.store', '#');

    $pageTitle = $isEdit ? 'Edit Mahasiswa' : 'Tambah Mahasiswa';
    $kipkOptions = [
        1 => 'KIPK',
        0 => 'Non KIPK',
    ];
@endphp

<x-admin-layout :title="$pageTitle" :page-title="$pageTitle" active="mahasiswa">
    <div class="space-y-6">
        <x-admin.search-bar :placeholder="$pageTitle">
            <x-admin.action-button :href="$safeRoute('admin.mahasiswa.index', '/admin/mahasiswa')" variant="secondary" icon="bi-arrow-left">Kembali</x-admin.action-button>
        </x-admin.search-bar>

        <x-admin.panel :title="$pageTitle" icon="bi-person-plus">
            <form method="POST" action="{{ $formAction }}" class="space-y-4">
                @csrf
                @if ($isEdit)
                    @method('PUT')
                @endif

                <x-admin.form-field
                    label="NIM"
                    name="nim"
                    placeholder="contoh: 09031282226001"
                    :value="old('nim', data_get($mahasiswaData, 'nim'))"
                />

                <x-admin.form-field
                    label="Nama Lengkap"
                    name="nama"
                    placeholder="contoh: Rahma Afvira"
                    :value="old('nama', data_get($mahasiswaData, 'nama'))"
                />

                <x-admin.form-field
                    label="Email"
                    name="email"
                    type="email"
                    placeholder="contoh: rahma@sihum.test"
                    :value="old('email', data_get($mahasiswaData, 'email'))"
                />

                <x-admin.form-field
                    label="Program Studi"
                    name="prodi"
                    placeholder="contoh: Sistem Informasi"
                    :value="old('prodi', data_get($mahasiswaData, 'prodi'))"
                />

                <x-admin.form-field
                    label="Nomor HP"
                    name="no_hp"
                    placeholder="contoh: 08123456789"
                    :value="old('no_hp', data_get($mahasiswaData, 'no_hp'))"
                />

                <x-admin.select-field
                    label="Status KIPK"
                    name="status_kipk"
                    :options="$kipkOptions"
                    placeholder="Pilih status KIPK"
                    :value="old('status_kipk', data_get($mahasiswaData, 'status_kipk') ? 1 : 0)"
                />

                <x-admin.form-field
                    label="Foto Profil (URL)"
                    name="foto_profil"
                    placeholder="contoh: https://..."
                    :value="old('foto_profil', data_get($mahasiswaData, 'foto_profil'))"
                />

                <div class="flex flex-col gap-3 pt-3 sm:flex-row sm:justify-end">
                    <x-admin.action-button :href="$safeRoute('admin.mahasiswa.index', '/admin/mahasiswa')" variant="secondary" icon="bi-x-lg">Batal</x-admin.action-button>
                    <x-admin.action-button type="submit" variant="dark" icon="bi-save">
                        {{ $isEdit ? 'Perbarui Mahasiswa' : 'Simpan Mahasiswa' }}
                    </x-admin.action-button>
                </div>
            </form>
        </x-admin.panel>
    </div>
</x-admin-layout>
