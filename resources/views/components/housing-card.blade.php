@props([
    'name',
    'type',
    'location',
    'capacity',
    'price',
    'status' => 'Tersedia',
    'href' => '#',
    'icon' => 'bi-building',
])

<article {{ $attributes->merge(['class' => 'group overflow-hidden rounded-[2rem] bg-bg-base shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl']) }}>
    <div class="relative bg-bg-surface p-6">
        <div class="absolute right-5 top-5 rounded-full bg-bg-base px-3 py-1 text-xs font-black text-brand shadow-sm">{{ $status }}</div>
        <div class="flex h-40 items-center justify-center rounded-[1.5rem] bg-brand-soft text-brand">
            <i class="bi {{ $icon }} text-7xl"></i>
        </div>
    </div>

    <div class="p-6">
        <span class="inline-flex rounded-full bg-brand-soft px-3 py-1 text-xs font-black uppercase tracking-[0.14em] text-brand">{{ $type }}</span>
        <h2 class="mt-4 text-xl font-black text-content-main">{{ $name }}</h2>

        <div class="mt-5 grid gap-3 text-sm text-content-sub">
            <p class="flex items-center gap-2"><i class="bi bi-geo-alt text-brand"></i>{{ $location }}</p>
            <p class="flex items-center gap-2"><i class="bi bi-people text-brand"></i>{{ $capacity }}</p>
            <p class="flex items-center gap-2"><i class="bi bi-wallet2 text-brand"></i>{{ $price }}</p>
        </div>

        <a href="{{ $href }}" class="mt-6 inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-brand px-5 py-3 text-sm font-black text-white shadow-lg shadow-brand/20 transition duration-300 group-hover:bg-brand/90">
            Lihat Detail
            <i class="bi bi-arrow-right"></i>
        </a>
    </div>
</article>
