@props([
    'href' => '#',
    'active' => false,
    'count' => null,
])

<a href="{{ $href }}" {{ $attributes->class([
    'inline-flex min-h-11 items-center justify-center rounded-2xl px-4 text-sm font-semibold transition',
    'bg-brand text-white shadow-sm' => $active,
    'text-content-main hover:bg-brand-light hover:text-brand' => ! $active,
]) }}>
    <span>{{ $slot }}</span>
    @if (! is_null($count))
        <span class="ml-2 rounded-full {{ $active ? 'bg-white/20 text-white' : 'bg-bg-surface text-content-sub' }} px-2 py-0.5 text-xs">{{ $count }}</span>
    @endif
</a>
