@php
    $mahasiswaSource = $mahasiswa ?? $students ?? collect();
    $mahasiswaItems = method_exists($mahasiswaSource, 'items') ? collect($mahasiswaSource->items()) : collect($mahasiswaSource);

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
    <div
        x-data="{
            modalOpen: false,
            detail: {
                nama: '-',
                nim: '-',
                prodi: '-',
                status_kipk: '-',
                no_hp: '-',
                hunian: '-',
                kamar: '-',
                status_hunian: '-',
            },
            openModal(payload) {
                this.detail = { ...this.detail, ...payload };
                this.modalOpen = true;
            },
            closeModal() {
                this.modalOpen = false;
            },
        }"
        class="space-y-6"
        @keydown.escape.window="closeModal()"
    >
        <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-5">
            @foreach ($stats as $stat)
                <x-admin.stat-card :label="$stat['label']" :value="$stat['value']" :icon="$stat['icon']" />
            @endforeach
        </section>

        <x-admin.search-bar placeholder="Cari Mahasiswa" class="xl:items-center">
            <x-admin.action-button variant="secondary" icon="bi-funnel">Filter</x-admin.action-button>
            <x-admin.action-button :href="$safeRoute('admin.mahasiswa.create', '/admin/mahasiswa/create')" icon="bi-plus-lg">Tambah Mahasiswa</x-admin.action-button>
        </x-admin.search-bar>

        <section>
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
                                    $statusHunian = data_get($student, 'status_hunian', data_get($student, 'penempatan.status', 'Belum Aktif'));
                                    $detailPayload = [
                                        'nama' => data_get($student, 'nama', data_get($student, 'user.name', '-')),
                                        'nim' => data_get($student, 'nim', '-'),
                                        'prodi' => data_get($student, 'prodi', '-'),
                                        'status_kipk' => data_get($student, 'status_kipk') ? 'Terdaftar KIPK' : 'Non KIPK',
                                        'no_hp' => data_get($student, 'no_hp', '-'),
                                        'hunian' => data_get($student, 'hunian.nama_hunian', data_get($student, 'penempatan.kamar.hunian.nama_hunian', '-')),
                                        'kamar' => data_get($student, 'kamar.nomor_kamar', data_get($student, 'penempatan.kamar.nomor_kamar', '-')),
                                        'status_hunian' => $statusHunian,
                                    ];
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
                                        <div class="flex items-center gap-2">
                                            <button
                                                type="button"
                                                class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-border-soft text-content-sub transition hover:border-brand hover:bg-brand-light hover:text-brand"
                                                aria-label="Detail mahasiswa"
                                                @click='openModal(@json($detailPayload))'
                                            >
                                                <i class="bi bi-info-circle"></i>
                                            </button>
                                            <a
                                                href="{{ $safeRouteWithParam('admin.mahasiswa.edit', $id, '/admin/mahasiswa/' . $id . '/edit') }}"
                                                class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-border-soft text-content-sub transition hover:border-brand hover:bg-brand-light hover:text-brand"
                                                aria-label="Edit mahasiswa"
                                            >
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <button
                                                type="button"
                                                class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-border-soft text-content-sub transition hover:border-red-200 hover:bg-red-50 hover:text-red-700"
                                                aria-label="Hapus mahasiswa"
                                            >
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
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
        </section>

        <div
            x-cloak
            x-show="modalOpen"
            x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center px-4 py-6 sm:px-6"
            aria-modal="true"
            role="dialog"
        >
            <div class="fixed inset-0 bg-content-main/50" @click="closeModal()"></div>
            <div class="relative w-full max-w-2xl">
                <x-admin.panel title="Detail Mahasiswa" icon="bi-person-vcard">
                    <x-slot:actions>
                        <button
                            type="button"
                            class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-border-soft text-content-sub transition hover:border-brand hover:bg-brand-light hover:text-brand"
                            aria-label="Tutup modal"
                            @click="closeModal()"
                        >
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </x-slot:actions>

                    <div class="space-y-5">
                        <div class="flex items-center gap-4">
                            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-brand-soft text-2xl font-bold text-brand">
                                <span x-text="detail.nama ? detail.nama.charAt(0).toUpperCase() : 'M'"></span>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-content-main" x-text="detail.nama"></h3>
                                <p class="text-sm text-content-sub">
                                    <span x-text="detail.nim"></span>
                                    <span> · </span>
                                    <span x-text="detail.prodi"></span>
                                </p>
                            </div>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="space-y-1">
                                <p class="text-xs font-semibold uppercase tracking-wide text-content-sub">Status KIPK</p>
                                <p class="text-sm font-medium text-content-main" x-text="detail.status_kipk"></p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-xs font-semibold uppercase tracking-wide text-content-sub">Nomor HP</p>
                                <p class="text-sm font-medium text-content-main" x-text="detail.no_hp"></p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-xs font-semibold uppercase tracking-wide text-content-sub">Hunian Aktif</p>
                                <p class="text-sm font-medium text-content-main" x-text="detail.hunian"></p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-xs font-semibold uppercase tracking-wide text-content-sub">Kamar</p>
                                <p class="text-sm font-medium text-content-main" x-text="detail.kamar"></p>
                            </div>
                            <div class="space-y-1 sm:col-span-2">
                                <p class="text-xs font-semibold uppercase tracking-wide text-content-sub">Status Hunian</p>
                                <p class="text-sm font-medium text-content-main" x-text="detail.status_hunian"></p>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3 pt-2 sm:flex-row sm:justify-end">
                            <button
                                type="button"
                                class="inline-flex items-center justify-center gap-2 rounded-2xl border border-border-soft bg-bg-base px-4 py-2.5 text-sm font-semibold text-content-main transition hover:border-brand hover:bg-brand-light hover:text-brand"
                                @click="closeModal()"
                            >
                                Tutup
                            </button>
                        </div>
                    </div>
                </x-admin.panel>
            </div>
        </div>
    </div>
</x-admin-layout>
