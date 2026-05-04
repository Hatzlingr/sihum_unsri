@props([
    'href' => '#',
    'icon' => 'bi-circle',
    'active' => false,
])

<a
    href="{{ $href }}"
    {{ $attributes->class([
        'group flex items-center gap-3 rounded-2xl px-3 py-2.5 text-sm font-medium transition',
        'bg-brand text-white shadow-sm shadow-brand/20' => $active,
        'text-content-main hover:bg-brand-light hover:text-brand' => ! $active,
    ]) }}
>
    <i class="bi {{ $icon }} text-base {{ $active ? 'text-white' : 'text-content-sub group-hover:text-brand' }}"></i>
    <span class="leading-tight">{{ $slot }}</span>
</a>
