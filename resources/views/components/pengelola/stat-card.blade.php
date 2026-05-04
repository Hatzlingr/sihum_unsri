@props([
    'label',
    'value' => null,
    'icon' => 'bi-bar-chart',
    'description' => null,
])

<article {{ $attributes->class('rounded-3xl border border-border-soft bg-bg-base p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-brand/40 hover:shadow-md') }}>
    <div class="flex items-start justify-between gap-4">
        <div class="min-w-0">
            <p class="text-sm font-medium text-content-sub">{{ $label }}</p>
            @if (! is_null($value))
                <p class="mt-3 text-3xl font-bold tracking-tight text-content-main">{{ $value }}</p>
            @else
                <div class="mt-6 h-10 rounded-2xl bg-bg-surface"></div>
            @endif
        </div>
        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-brand-soft text-brand">
            <i class="bi {{ $icon }} text-lg"></i>
        </span>
    </div>

    @if ($description)
        <p class="mt-4 text-xs text-content-sub">{{ $description }}</p>
    @endif
</article>
