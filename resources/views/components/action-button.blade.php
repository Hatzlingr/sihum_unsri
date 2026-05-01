@props([
    'href' => '#',
    'variant' => 'primary',
    'icon' => null,
])

<a
    href="{{ $href }}"
    @class([
        'inline-flex items-center justify-center gap-2 rounded-2xl px-7 py-4 text-sm font-black transition duration-300 hover:-translate-y-0.5',
        'bg-brand text-white shadow-lg shadow-brand/20 hover:bg-brand/90 hover:shadow-xl hover:shadow-brand/20' => $variant === 'primary',
        'bg-bg-base text-brand shadow-sm hover:bg-brand-soft hover:shadow-md' => $variant === 'secondary',
        'bg-bg-surface text-content-main shadow-sm hover:bg-brand-soft hover:text-brand hover:shadow-md' => $variant === 'surface',
    ])
>
    <span>{{ $slot }}</span>
    @if ($icon)
        <i class="bi {{ $icon }}"></i>
    @endif
</a>
