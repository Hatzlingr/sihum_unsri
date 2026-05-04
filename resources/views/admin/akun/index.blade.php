@php
    $usersSource = $users ?? $accounts ?? $pengelola ?? collect();
    $userItems = method_exists($usersSource, 'items') ? collect($usersSource->items()) : collect($usersSource);
    $hunianOptions = collect($hunians ?? [])->mapWithKeys(fn ($hunian) => [data_get($hunian, 'id_hunian') => data_get($hunian, 'nama_hunian')])->all();
    $roleOptions = $roleOptions ?? ['admin' => 'Admin', 'pengelola' => 'Pengelola', 'mahasiswa' => 'Mahasiswa'];
    $safeRoute = static fn (string $name, string $fallback) => \Illuminate\Support\Facades\Route::has($name) ? route($name) : url($fallback);
    $safeRouteWithParam = static fn (string $name, $param, string $fallback) => \Illuminate\Support\Facades\Route::has($name) ? route($name, $param) : url($fallback);
@endphp

<x-admin-layout title="Manajemen Akun" page-title="Manajemen Akun" active="akun">
    <div class="space-y-6">
        <x-admin.search-bar placeholder="Cari Akun" class="xl:grid xl:grid-cols-[minmax(260px,1fr)_repeat(5,minmax(120px,180px))]">
            <select name="role" class="h-12 rounded-2xl border border-border-soft bg-bg-base px-4 text-sm outline-none transition focus:border-brand focus:ring-4 focus:ring-brand-soft">
                <option value="">Filter Role</option>
                @foreach ($roleOptions as $value => $label)
                    <option value="{{ $value }}" @selected(request('role') == $value)>{{ $label }}</option>
                @endforeach
            </select>
            <select name="hunian_id" class="h-12 rounded-2xl border border-border-soft bg-bg-base px-4 text-sm outline-none transition focus:border-brand focus:ring-4 focus:ring-brand-soft">
                <option value="">Filter Hunian</option>
                @foreach ($hunianOptions as $value => $label)
                    <option value="{{ $value }}" @selected(request('hunian_id') == $value)>{{ $label }}</option>
                @endforeach
            </select>
            <select name="status" class="h-12 rounded-2xl border border-border-soft bg-bg-base px-4 text-sm outline-none transition focus:border-brand focus:ring-4 focus:ring-brand-soft">
                <option value="">Filter Status</option>
                <option value="aktif" @selected(request('status') === 'aktif')>Aktif</option>
                <option value="nonaktif" @selected(request('status') === 'nonaktif')>Nonaktif</option>
            </select>
            <x-admin.action-button :href="url()->current()" variant="muted" icon="bi-arrow-counterclockwise">Reset</x-admin.action-button>
            <x-admin.action-button :href="$safeRoute('admin.akun.create', '/admin/akun/create')" icon="bi-plus-lg">Tambah Akun</x-admin.action-button>
        </x-admin.search-bar>
        <x-admin.panel padding="p-0">
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="border-b border-border-soft bg-bg-surface text-xs font-semibold uppercase tracking-wide text-content-sub">
                        <tr>
                            <th class="px-5 py-4">Email</th>
                            <th class="px-5 py-4">Username</th>
                            <th class="px-5 py-4">Role</th>
                            <th class="px-5 py-4">Hunian</th>
                            <th class="px-5 py-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-soft">
                        @forelse ($userItems as $user)
                            @php
                                $id = data_get($user, 'id', data_get($user, 'id_user', data_get($user, 'id_pengelola', 0)));
                            @endphp
                            <tr class="transition hover:bg-brand-light/50">
                                <td class="px-5 py-4 font-semibold text-content-main">{{ data_get($user, 'email', '-') }}</td>
                                <td class="px-5 py-4 text-content-sub">{{ data_get($user, 'username', data_get($user, 'name', '-')) }}</td>
                                <td class="px-5 py-4"><x-admin.status-badge :status="data_get($user, 'role', '-')" /></td>
                                <td class="px-5 py-4 text-content-sub">{{ data_get($user, 'pengelola.hunian.nama_hunian', data_get($user, 'hunian.nama_hunian', '-')) }}</td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ $safeRouteWithParam('admin.akun.edit', $id, '/admin/akun/' . $id . '/edit') }}" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-border-soft text-content-sub transition hover:border-brand hover:bg-brand-light hover:text-brand" aria-label="Edit akun">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-border-soft text-content-sub transition hover:border-red-200 hover:bg-red-50 hover:text-red-700" aria-label="Hapus akun">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-6">
                                    <x-admin.skeleton-list :rows="9" height="h-11" />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-border-soft px-5 pb-5">
                <x-admin.pagination :paginator="$usersSource" />
            </div>
        </x-admin.panel>
    </div>
</x-admin-layout>
