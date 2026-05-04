@php
    $mahasiswaSource = $mahasiswa ?? $students ?? collect();
    $mahasiswaItems = method_exists($mahasiswaSource, 'items') ? collect($mahasiswaSource->items()) : collect($mahasiswaSource);
    $selected = $selectedMahasiswa ?? $mahasiswaItems->first();

    $stats = $stats ?? [
        ['label' => 'Total Terdaftar', 'value' => $totalTerdaftar ?? $mahasiswaItems->count(), 'icon' => 'bi-people'],
        ['label' => 'Aktif Hunian', 'value' => $aktifHunian ?? 0, 'icon' => 'bi-house-check'],
        ['label' => 'Belum Bayar', 'value' => $belumBayar ?? 0, 'icon' => 'bi-wallet2'],
        ['label' => 'KIPK', 'value' => $totalKipk ?? $mahasiswaItems->where('status_kipk', true)->count(), 'icon' => 'bi-patch-check'],
        ['label' => 'Non KIPK', 'value' => $totalNonKipk ?? $mahasiswaItems->where('status_kipk', false)->count(), 'icon' => 'bi-person'],
    ];

    $safeRoute = static fn (string $name, string $fallback) => \Illuminate\Support\Facades\Route::has($name) ? route($name) : url($fallback);
    $safeRouteWithParam = static fn (string $name, $param, string $fallback) => \Illuminate\Support\Facades\Route::has($name) ? route($name, $param) : url($fallback);
@endphp

<x-admin-layout title="Manajemen Mahasiswa" page-title="Manajemen Mahasiswa" active="mahasiswa">
    <div class="space-y-6">
        <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-5">
            @foreach ($stats as $stat)
                <x-admin.stat-card :label="$stat['label']" :value="$stat['value']" :icon="$stat['icon']" />
            @endforeach
        </section>

        <x-admin.search-bar placeholder="Cari Mahasiswa" class="xl:items-center">
            <x-admin.action-button variant="secondary" icon="bi-funnel">Filter</x-admin.action-button>
            <x-admin.action-button :href="$safeRoute('admin.mahasiswa.create', '/admin/mahasiswa/create')" icon="bi-plus-lg">Tambah Mahasiswa</x-admin.action-button>
        </x-admin.search-bar>

        <section class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">
            <x-admin.panel title="Daftar Mahasiswa" icon="bi-mortarboard" padding="p-0">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left text-sm">
                        <thead class="border-b border-border-soft bg-bg-surface text-xs font-semibold uppercase tracking-wide text-content-sub">
                            <tr>
                                <th class="px-5 py-4">NIM</th>
                                <th class="px-5 py-4">Nama</th>
                                <th class="px-5 py-4">Prodi</th>
                                <th class="px-5 py-4">KIPK</th>
                                <th class="px-5 py-4">Status Hunian</th>
                                <th class="px-5 py-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border-soft">
                            @forelse ($mahasiswaItems as $student)
                                @php
                                    $id = data_get($student, 'id_mahasiswa', data_get($student, 'id'));
                                    $rowUrl = request()->fullUrlWithQuery(['selected' => $id]);
                                    $statusHunian = data_get($student, 'status_hunian', data_get($student, 'penempatan.status', 'Belum Aktif'));
                                @endphp
                                <tr class="transition hover:bg-brand-light/50">
                                    <td class="px-5 py-4 font-semibold text-content-main">{{ data_get($student, 'nim', '-') }}</td>
                                    <td class="px-5 py-4 text-content-main">{{ data_get($student, 'nama', data_get($student, 'user.name', '-')) }}</td>
                                    <td class="px-5 py-4 text-content-sub">{{ data_get($student, 'prodi', '-') }}</td>
                                    <td class="px-5 py-4">
                                        <x-admin.status-badge :status="data_get($student, 'status_kipk') ? 'KIPK' : 'Non KIPK'" />
                                    </td>
                                    <td class="px-5 py-4"><x-admin.status-badge :status="$statusHunian" /></td>
                                    <td class="px-5 py-4">
                                        <a href="{{ $rowUrl }}" class="inline-flex items-center gap-1 font-semibold text-brand hover:underline">
                                            Detail <i class="bi bi-chevron-right text-xs"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-5 py-5">
                                        <x-admin.skeleton-list :rows="10" height="h-11" />
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="border-t border-border-soft px-5 pb-5">
                    <x-admin.pagination :paginator="$mahasiswaSource" />
                </div>
            </x-admin.panel>

            <x-admin.panel title="Detail Mahasiswa" icon="bi-person-vcard">
                @if ($selected)
                    <div class="space-y-5">
                        <div class="flex items-center gap-4">
                            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-brand-soft text-2xl font-bold text-brand">
                                {{ strtoupper(substr(data_get($selected, 'nama', data_get($selected, 'user.name', 'M')), 0, 1)) }}
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-content-main">{{ data_get($selected, 'nama', data_get($selected, 'user.name', '-')) }}</h3>
                                <p class="text-sm text-content-sub">{{ data_get($selected, 'nim', '-') }} · {{ data_get($selected, 'prodi', '-') }}</p>
                            </div>
                        </div>

                        <div class="grid gap-4">
                            <x-admin.detail-row label="Status KIPK" :value="data_get($selected, 'status_kipk') ? 'Terdaftar KIPK' : 'Non KIPK'" />
                            <x-admin.detail-row label="Nomor HP" :value="data_get($selected, 'no_hp', '-')" />
                            <x-admin.detail-row label="Hunian Aktif" :value="data_get($selected, 'hunian.nama_hunian', data_get($selected, 'penempatan.kamar.hunian.nama_hunian', '-'))" />
                            <x-admin.detail-row label="Kamar" :value="data_get($selected, 'kamar.nomor_kamar', data_get($selected, 'penempatan.kamar.nomor_kamar', '-'))" />
                            <x-admin.detail-row label="Status Hunian" :value="data_get($selected, 'status_hunian', data_get($selected, 'penempatan.status', 'Belum Aktif'))" />
                        </div>

                        <div class="grid grid-cols-2 gap-3 pt-3">
                            <x-admin.action-button :href="$safeRouteWithParam('admin.mahasiswa.edit', data_get($selected, 'id_mahasiswa', 0), '/admin/mahasiswa/' . data_get($selected, 'id_mahasiswa', 0) . '/edit')" variant="secondary" icon="bi-pencil-square">Edit</x-admin.action-button>
                            <x-admin.action-button variant="danger" icon="bi-trash">Hapus</x-admin.action-button>
                            <x-admin.action-button :href="$safeRoute('admin.mahasiswa.index', '/admin/mahasiswa')" variant="muted" icon="bi-clock-history" class="col-span-2">Riwayat</x-admin.action-button>
                        </div>
                    </div>
                @else
                    <x-admin.skeleton-list :rows="8" height="h-11" />
                    <div class="mt-6 grid grid-cols-2 gap-3">
                        <x-admin.action-button variant="secondary">Edit</x-admin.action-button>
                        <x-admin.action-button variant="secondary">Hapus</x-admin.action-button>
                        <x-admin.action-button variant="secondary" class="col-span-2">Riwayat</x-admin.action-button>
                    </div>
                @endif
            </x-admin.panel>
        </section>
    </div>
</x-admin-layout>
