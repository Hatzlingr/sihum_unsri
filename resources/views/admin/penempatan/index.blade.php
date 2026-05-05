@php
    $calonSource = $calonPenempatan ?? $pendaftaranDisetujui ?? $mahasiswa ?? collect();
    $calonItems = method_exists($calonSource, 'items') ? collect($calonSource->items()) : collect($calonSource);
    $assignTemplate = \Illuminate\Support\Facades\Route::has('admin.penempatan.store')
        ? route('admin.penempatan.store', ['id' => '__ID__'])
        : '#';
@endphp

<x-admin-layout title="Penempatan" page-title="Penempatan" active="penempatan">
    <div
        x-data="{
            modalOpen: false,
            assignTemplate: @js($assignTemplate),
            detail: {
                id: null,
                nama: '-',
                nim: '-',
                prodi: '-',
                status_kipk: '-',
                gender: '-',
                hunian: '-',
                rooms: [],
            },
            openModal(payload) {
                this.detail = { ...this.detail, ...payload };
                this.modalOpen = true;
            },
            closeModal() {
                this.modalOpen = false;
            },
            assignAction() {
                return this.assignTemplate === '#'
                    ? '#'
                    : this.assignTemplate.replace('__ID__', this.detail.id ?? '');
            },
        }"
        class="space-y-6"
        @keydown.escape.window="closeModal()"
    >
        <x-admin.search-bar placeholder="Cari Nama atau NIM" />

        <section>
            <x-admin.panel padding="p-5 sm:p-6">
                <div class="space-y-4">
                    @forelse ($calonItems as $item)
                        @php
                            $id = data_get($item, 'id_daftar', data_get($item, 'id_mahasiswa', data_get($item, 'id')));
                            $student = data_get($item, 'mahasiswa', $item);
                            $hunian = data_get($item, 'hunian', data_get($item, 'pendaftaran.hunian'));
                            $rooms = collect(data_get($hunian, 'kamar', []));
                            $roomsPayload = $rooms->map(function ($room) {
                                $status = data_get($room, 'status', 'Tersedia');
                                $kapasitas = (int) data_get($room, 'kapasitas', 0);
                                $terisi = (int) data_get($room, 'terisi', 0);
                                $available = $status === 'Tersedia' && $terisi < max($kapasitas, 1);

                                return [
                                    'id' => data_get($room, 'id_kamar'),
                                    'nomor' => data_get($room, 'nomor_kamar', '-'),
                                    'lantai' => data_get($room, 'lantai', '-'),
                                    'kapasitas' => $kapasitas,
                                    'terisi' => $terisi,
                                    'status' => $available ? 'Tersedia' : $status,
                                    'available' => $available,
                                ];
                            })->values()->all();
                            $detailPayload = [
                                'id' => $id,
                                'nama' => data_get($student, 'nama', '-'),
                                'nim' => data_get($student, 'nim', '-'),
                                'prodi' => data_get($student, 'prodi', '-'),
                                'status_kipk' => data_get($student, 'status_kipk') ? 'KIPK' : 'Non KIPK',
                                'gender' => data_get($student, 'jenis_kelamin', data_get($student, 'gender', '-')),
                                'hunian' => data_get($hunian, 'nama_hunian', '-'),
                                'rooms' => $roomsPayload,
                            ];
                        @endphp
                        <div class="rounded-3xl border border-border-soft bg-bg-surface p-5 transition hover:border-brand hover:bg-brand-light" x-data="{ payload: {{ \Illuminate\Support\Js::from($detailPayload) }} }">
                            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                                <div>
                                    <h3 class="text-xl font-bold text-content-main">{{ data_get($student, 'nama', '-') }}</h3>
                                    <p class="mt-2 text-sm text-content-sub">{{ data_get($student, 'nim', '-') }} · {{ data_get($student, 'prodi', '-') }} · {{ data_get($student, 'status_kipk') ? 'KIPK' : 'Non KIPK' }}</p>
                                    <div class="mt-3 h-px bg-border-soft"></div>
                                    <p class="mt-3 text-sm font-semibold text-content-main">{{ data_get($student, 'jenis_kelamin', data_get($student, 'gender', '-')) }}</p>
                                    <p class="mt-2 text-sm font-semibold text-content-main">{{ data_get($hunian, 'nama_hunian', '-') }}</p>
                                </div>
                                <x-admin.action-button type="button" variant="secondary" icon="bi-pin-map" @click="openModal(payload)">Penempatan</x-admin.action-button>
                            </div>
                        </div>
                    @empty
                        <x-admin.skeleton-list :rows="8" height="h-12" />
                    @endforelse
                </div>

                <x-admin.pagination :paginator="$calonSource" />
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
            <div class="relative w-full max-w-4xl">
                <x-admin.panel title="Penempatan Kamar" icon="bi-pin-map" padding="p-0">
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

                    <div class="p-5 sm:p-6">
                        <h3 class="text-2xl font-bold text-content-main" x-text="detail.hunian"></h3>
                        <p class="mt-1 text-content-sub">
                            Pilih kamar untuk
                            <span class="font-semibold text-content-main" x-text="detail.nama"></span>
                        </p>
                        <p class="mt-2 text-sm text-content-sub">
                            <span x-text="detail.nim"></span>
                            <span> · </span>
                            <span x-text="detail.prodi"></span>
                            <span> · </span>
                            <span x-text="detail.status_kipk"></span>
                        </p>
                    </div>

                    <form method="POST" x-bind:action="assignAction()" class="border-t border-border-soft p-5 sm:p-6">
                        @csrf
                        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            <template x-for="room in detail.rooms" :key="room.id">
                                <label
                                    class="cursor-pointer rounded-3xl border border-border-soft bg-bg-surface p-4 transition hover:border-brand hover:bg-brand-light"
                                    :class="room.available ? '' : 'opacity-60 cursor-not-allowed'"
                                >
                                    <input type="radio" name="kamar_id" :value="room.id" class="sr-only peer" :disabled="!room.available">
                                    <div class="flex items-start justify-between gap-3">
                                        <div>
                                            <p class="text-lg font-bold text-content-main">Kamar <span x-text="room.nomor"></span></p>
                                            <p class="mt-1 text-sm text-content-sub">
                                                <span x-text="room.terisi"></span>/<span x-text="room.kapasitas"></span> penghuni · Lantai <span x-text="room.lantai"></span>
                                            </p>
                                        </div>
                                        <span class="text-xs font-semibold" :class="room.available ? 'text-emerald-700' : 'text-content-sub'" x-text="room.status"></span>
                                    </div>
                                </label>
                            </template>
                            <template x-if="detail.rooms.length === 0">
                                <div class="rounded-3xl border border-dashed border-border-soft bg-bg-surface p-6 text-center text-sm text-content-sub">
                                    Tidak ada kamar tersedia untuk hunian ini.
                                </div>
                            </template>
                        </div>

                        <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:justify-end">
                            <x-admin.action-button type="button" variant="secondary" icon="bi-x-lg" @click="closeModal()">Batal</x-admin.action-button>
                            <x-admin.action-button type="submit" icon="bi-check2-circle">Assign Kamar Sekarang</x-admin.action-button>
                        </div>
                    </form>
                </x-admin.panel>
            </div>
        </div>
    </div>
</x-admin-layout>
