@props([
    'title' => 'Data belum tersedia',
    'description' => 'Data akan muncul setelah controller mengirimkan koleksi ke view ini.',
    'icon' => 'bi-inbox',
])

<div {{ $attributes->class('flex flex-col items-center justify-center rounded-3xl border border-dashed border-border-soft bg-bg-surface px-6 py-10 text-center') }}>
    <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-soft text-brand">
        <i class="bi {{ $icon }} text-2xl"></i>
    </span>
    <h3 class="mt-4 text-base font-semibold text-content-main">{{ $title }}</h3>
    <p class="mt-2 max-w-md text-sm text-content-sub">{{ $description }}</p>
</div>
