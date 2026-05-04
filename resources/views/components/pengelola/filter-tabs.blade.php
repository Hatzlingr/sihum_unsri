@props([
    'tabs' => [],
    'active' => null,
    'queryKey' => 'status',
])

@php
    $current = request($queryKey, $active ?? data_get($tabs, '0.key'));
@endphp

<div {{ $attributes->class('flex flex-wrap items-center justify-center gap-3') }}>
    @foreach ($tabs as $tab)
        @php
            $key = data_get($tab, 'key');
            $label = data_get($tab, 'label', $key);
            $icon = data_get($tab, 'icon');
            $isActive = (string) $current === (string) $key;
        @endphp
        <a
            href="{{ request()->fullUrlWithQuery([$queryKey => $key]) }}"
            class="inline-flex min-w-28 items-center justify-center gap-2 rounded-2xl border px-4 py-3 text-sm font-semibold transition {{ $isActive ? 'border-brand bg-brand text-white shadow-sm shadow-brand/20' : 'border-border-soft bg-bg-base text-content-main hover:border-brand hover:bg-brand-light hover:text-brand' }}"
        >
            @if ($icon)<i class="bi {{ $icon }}"></i>@endif
            {{ $label }}
        </a>
    @endforeach
</div>
