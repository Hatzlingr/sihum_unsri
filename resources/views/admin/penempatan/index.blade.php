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
            selectedFloor: 'all',
            selectedRoom: null,
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
                this.selectedFloor = 'all';
                this.selectedRoom = null;
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
            get floors() {
                const floors = this.detail.rooms
                    .map(room => room.lantai)
                    .filter(value => value !== null && value !== undefined && value !== '-');
                return [...new Set(floors)];
            },
            get filteredRooms() {
                if (this.selectedFloor === 'all') {
                    return this.detail.rooms;
                }
                return this.detail.rooms.filter(room => String(room.lantai) === String(this.selectedFloor));
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
                                            <button
                                                type="button"
                                                class="inline-flex items-center justify-center gap-2 rounded-2xl border border-border-soft bg-bg-base px-4 py-2.5 text-sm font-semibold text-content-main transition hover:border-brand hover:bg-brand-light hover:text-brand"
                                                @click='openModal(@json($detailPayload))'
                                            >
                                                <i class="bi bi-eye"></i>
                                                <span>Detail</span>
                                            </button>                              </div>
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
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <div class="text-sm text-content-sub">
                                Pilih lantai terlebih dahulu, lalu tentukan kamar.
                            </div>
                            <div class="flex items-center gap-3">
                                <label class="text-xs font-semibold uppercase tracking-wide text-content-sub">Filter Lantai</label>
                                <select
                                    x-model="selectedFloor"
                                    class="h-10 rounded-2xl border border-border-soft bg-bg-base px-4 text-sm outline-none transition focus:border-brand focus:ring-4 focus:ring-brand-soft"
                                >
                                    <option value="all">Semua</option>
                                    <template x-for="floor in floors" :key="floor">
                                        <option :value="floor" x-text="'Lantai ' + floor"></option>
                                    </template>
                                </select>
                            </div>
                        </div>

                        <div class="mt-4 overflow-x-auto">
                            <table class="min-w-full text-left text-sm">
                                <thead class="border-b border-border-soft text-xs uppercase tracking-wide text-content-sub">
                                    <tr>
                                        <th class="py-3 px-2">Pilih</th>
                                        <th class="py-3 px-2">Nomor</th>
                                        <th class="py-3 px-2">Lantai</th>
                                        <th class="py-3 px-2">Kapasitas</th>
                                        <th class="py-3 px-2">Terisi</th>
                                        <th class="py-3 px-2">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-border-soft">
                                    <template x-for="room in filteredRooms" :key="room.id">
                                        <tr :class="selectedRoom === room.id ? 'bg-brand-light' : ''">
                                            <td class="py-3 px-2">
                                                <input
                                                    type="radio"
                                                    name="kamar_id"
                                                    :value="room.id"
                                                    x-model="selectedRoom"
                                                    :disabled="!room.available"
                                                    class="h-4 w-4 rounded border-border-soft text-brand focus:ring-brand"
                                                >
                                            </td>
                                            <td class="py-3 px-2 font-semibold text-content-main" x-text="room.nomor"></td>
                                            <td class="py-3 px-2 text-content-sub" x-text="room.lantai"></td>
                                            <td class="py-3 px-2 text-content-sub" x-text="room.kapasitas"></td>
                                            <td class="py-3 px-2 text-content-sub" x-text="room.terisi"></td>
                                            <td class="py-3 px-2">
                                                <span
                                                    class="text-xs font-semibold"
                                                    :class="room.available ? 'text-emerald-700' : 'text-content-sub'"
                                                    x-text="room.status"
                                                ></span>
                                            </td>
                                        </tr>
                                    </template>
                                    <template x-if="filteredRooms.length === 0">
                                        <tr>
                                            <td colspan="6" class="py-4 text-center text-content-sub">
                                                Tidak ada kamar tersedia untuk lantai ini.
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
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
