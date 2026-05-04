@php
    $calonSource = $calonPenempatan ?? $pendaftaranDisetujui ?? $mahasiswa ?? collect();
    $calonItems = method_exists($calonSource, 'items') ? collect($calonSource->items()) : collect($calonSource);
    $selected = $selectedCalon ?? $selectedMahasiswa ?? $calonItems->first();
    $selectedHunian = $selectedHunian ?? data_get($selected, 'hunian', data_get($selected, 'pendaftaran.hunian'));
    $rooms = isset($kamarTersedia) ? collect($kamarTersedia) : collect(data_get($selectedHunian, 'kamar', []));
    $selectedLantai = request('lantai', $selectedLantai ?? data_get($rooms->first(), 'lantai', 2));
    $floorRooms = $rooms->isNotEmpty() ? $rooms->where('lantai', (int) $selectedLantai) : collect();
    $safeAction = static fn (string $name, $param, string $fallback) => \Illuminate\Support\Facades\Route::has($name) ? route($name, $param) : $fallback;
@endphp

<x-admin-layout title="Penempatan" page-title="Penempatan" active="penempatan">
    <section class="grid gap-6 xl:grid-cols-[420px_minmax(0,1fr)]">
        <x-admin.panel padding="p-5 sm:p-6">
            <x-admin.search-bar placeholder="Cari Nama atau NIM" class="mb-6" />

            <div class="space-y-4">
                @forelse ($calonItems as $item)
                    @php
                        $id = data_get($item, 'id_daftar', data_get($item, 'id_mahasiswa', data_get($item, 'id')));
                        $student = data_get($item, 'mahasiswa', $item);
                        $hunian = data_get($item, 'hunian', data_get($item, 'pendaftaran.hunian'));
                    @endphp
                    <a href="{{ request()->fullUrlWithQuery(['selected' => $id]) }}" class="block rounded-3xl border border-border-soft bg-bg-surface p-5 transition hover:border-brand hover:bg-brand-light">
                        <h3 class="text-xl font-bold text-content-main">{{ data_get($student, 'nama', '-') }}</h3>
                        <p class="mt-2 text-sm text-content-sub">{{ data_get($student, 'nim', '-') }} · {{ data_get($student, 'prodi', '-') }} · {{ data_get($student, 'status_kipk') ? 'KIPK' : 'Non KIPK' }}</p>
                        <div class="mt-3 h-px bg-border-soft"></div>
                        <p class="mt-3 text-sm font-semibold text-content-main">{{ data_get($student, 'jenis_kelamin', data_get($student, 'gender', '-')) }}</p>
                        <p class="mt-2 text-sm font-semibold text-content-main">{{ data_get($hunian, 'nama_hunian', '-') }}</p>
                    </a>
                @empty
                    <div class="rounded-3xl border border-border-soft bg-bg-surface p-5">
                        <h3 class="text-xl font-bold text-content-main">Rahma Afvira</h3>
                        <p class="mt-2 text-sm text-content-sub">09021282429069 · Teknik Informatika · KIPK</p>
                        <div class="mt-3 h-px bg-border-soft"></div>
                        <p class="mt-3 text-sm font-semibold text-content-main">Laki-laki</p>
                        <p class="mt-2 text-sm font-semibold text-content-main">Rusunawa Putra Lama</p>
                    </div>
                    <x-admin.skeleton-list :rows="5" height="h-12" />
                @endforelse
            </div>

            <x-admin.pagination :paginator="$calonSource" />
        </x-admin.panel>

        <x-admin.panel padding="p-0">
            <div class="flex flex-col gap-4 border-b border-border-soft p-5 sm:flex-row sm:items-center sm:justify-between sm:p-6">
                <div>
                    <h2 class="text-2xl font-bold text-content-main">{{ data_get($selectedHunian, 'nama_hunian', 'Rusunawa Putra Lama') }}</h2>
                    <p class="mt-1 text-content-sub">
                        Pilih kamar untuk
                        <span class="font-semibold text-content-main">{{ data_get($selected, 'mahasiswa.nama', data_get($selected, 'nama', 'Rahma Afvira')) }}</span>
                    </p>
                </div>

                <form method="GET" class="shrink-0">
                    @foreach (request()->except('lantai') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <label class="sr-only" for="lantai">Lantai</label>
                    <select id="lantai" name="lantai" onchange="this.form.submit()" class="h-11 rounded-2xl border border-border-soft bg-bg-base px-4 text-sm font-semibold outline-none focus:border-brand focus:ring-4 focus:ring-brand-soft">
                        @foreach (($rooms->pluck('lantai')->unique()->sort()->values()->all() ?: [1, 2, 3]) as $lantai)
                            <option value="{{ $lantai }}" @selected((int) $selectedLantai === (int) $lantai)>Lantai {{ $lantai }}</option>
                        @endforeach
                    </select>
                </form>
            </div>

            <div class="min-h-[460px] p-5 sm:p-8 lg:p-10">
                @if ($floorRooms->isNotEmpty())
                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4">
                        @foreach ($floorRooms as $room)
                            @php
                                $status = data_get($room, 'status', 'Tersedia');
                                $isAvailable = $status === 'Tersedia' && (int) data_get($room, 'terisi', 0) < (int) data_get($room, 'kapasitas', 1);
                            @endphp
                            <label class="cursor-pointer rounded-3xl border border-border-soft bg-bg-surface p-4 transition hover:border-brand hover:bg-brand-light">
                                <input type="radio" name="kamar_id_preview" value="{{ data_get($room, 'id_kamar') }}" class="sr-only peer">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="text-lg font-bold text-content-main">Kamar {{ data_get($room, 'nomor_kamar', '-') }}</p>
                                        <p class="mt-1 text-sm text-content-sub">{{ data_get($room, 'terisi', 0) }}/{{ data_get($room, 'kapasitas', 0) }} penghuni</p>
                                    </div>
                                    <x-admin.status-badge :status="$isAvailable ? 'Tersedia' : $status" />
                                </div>
                            </label>
                        @endforeach
                    </div>
                @else
                    <div class="flex min-h-[420px] items-center justify-center rounded-3xl border border-dashed border-border-soft bg-bg-surface">
                        <div class="text-center">
                            <p class="text-5xl font-bold text-content-main sm:text-7xl">Denah Hunian</p>
                            <p class="mt-4 text-sm text-content-sub">Grid kamar akan muncul saat data kamar tersedia.</p>
                        </div>
                    </div>
                @endif
            </div>

            <div class="flex flex-col gap-4 border-t border-border-soft p-5 sm:flex-row sm:items-center sm:justify-between sm:p-6">
                <h3 class="text-xl font-bold text-content-main">Konfirmasi Penempatan</h3>
                <div class="flex flex-col gap-3 sm:flex-row">
                    <x-admin.action-button variant="secondary" icon="bi-x-lg">Batal</x-admin.action-button>
                    <form method="POST" action="{{ $safeAction('admin.penempatan.store', data_get($selected, 'id_daftar', 0), '#') }}">
                        @csrf
                        <x-admin.action-button type="submit" icon="bi-check2-circle">Assign Kamar Sekarang</x-admin.action-button>
                    </form>
                </div>
            </div>
        </x-admin.panel>
    </section>
</x-admin-layout>
