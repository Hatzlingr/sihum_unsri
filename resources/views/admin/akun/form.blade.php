@php
    $userData = $user ?? $account ?? $pengelolaUser ?? null;
    $userId = $userId ?? data_get($userData, 'id', data_get($userData, 'id_user', data_get($userData, 'id_pengelola')));
    $isEdit = !empty($userId);

    $hunianOptions = collect($hunians ?? [])->mapWithKeys(fn ($hunian) => [data_get($hunian, 'id_hunian') => data_get($hunian, 'nama_hunian')])->all();
    $roleOptions = $roleOptions ?? ['admin' => 'Admin', 'pengelola' => 'Pengelola', 'mahasiswa' => 'Mahasiswa'];

    $safeRoute = static fn (string $name, string $fallback) => \Illuminate\Support\Facades\Route::has($name) ? route($name) : url($fallback);
    $safeRouteWithParam = static fn (string $name, $param, string $fallback) => \Illuminate\Support\Facades\Route::has($name) ? route($name, $param) : url($fallback);

    // TODO: Wire controller routes for store/update when ready.
    $formAction = $isEdit
        ? $safeRouteWithParam('admin.akun.update', $userId, '#')
        : $safeRoute('admin.akun.store', '#');

    $pageTitle = $isEdit ? 'Edit Akun' : 'Buat Akun Baru';
@endphp

<x-admin-layout :title="$pageTitle" :page-title="$pageTitle" active="akun">
    <div class="space-y-6">
        <x-admin.search-bar :placeholder="$pageTitle">
            <x-admin.action-button :href="$safeRoute('admin.akun.index', '/admin/akun')" variant="secondary" icon="bi-arrow-left">Kembali</x-admin.action-button>
        </x-admin.search-bar>

        <x-admin.panel :title="$pageTitle" icon="bi-person-plus">
            <form method="POST" action="{{ $formAction }}" class="space-y-4">
                @csrf
                @if ($isEdit)
                    @method('PUT')
                @endif

                <x-admin.form-field
                    label="Nama Lengkap"
                    name="name"
                    placeholder="contoh: Rahma Afvira"
                    :value="old('name', data_get($userData, 'name'))"
                />

                <x-admin.form-field
                    label="Username"
                    name="username"
                    placeholder="contoh: rahma.afvira"
                    :value="old('username', data_get($userData, 'username'))"
                />

                <x-admin.form-field
                    label="Email"
                    name="email"
                    type="email"
                    placeholder="contoh: rahma@sihum.test"
                    :value="old('email', data_get($userData, 'email'))"
                />

                <x-admin.form-field
                    label="Password"
                    name="password"
                    type="password"
                    placeholder="Kosongkan jika tidak diubah"
                />

                <x-admin.select-field
                    label="Role"
                    name="role"
                    :options="$roleOptions"
                    placeholder="Pilih role akun"
                    :value="old('role', data_get($userData, 'role'))"
                />

                <x-admin.select-field
                    label="Assign Hunian"
                    name="hunian_id"
                    :options="$hunianOptions"
                    placeholder="Pilih hunian untuk pengelola"
                    :value="old('hunian_id', data_get($userData, 'hunian_id'))"
                />

                <div class="flex flex-col gap-3 pt-3 sm:flex-row sm:justify-end">
                    <x-admin.action-button :href="$safeRoute('admin.akun.index', '/admin/akun')" variant="secondary" icon="bi-x-lg">Batal</x-admin.action-button>
                    <x-admin.action-button type="submit" variant="dark" icon="bi-save">
                        {{ $isEdit ? 'Perbarui Akun' : 'Buat Akun' }}
                    </x-admin.action-button>
                </div>
            </form>
        </x-admin.panel>
    </div>
</x-admin-layout>
