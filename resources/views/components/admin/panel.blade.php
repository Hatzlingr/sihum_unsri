@props([
    'title' => null,
    'description' => null,
    'icon' => null,
    'padding' => 'p-5 sm:p-6',
])

<section {{ $attributes->class('overflow-hidden rounded-3xl border border-border-soft bg-bg-base shadow-sm') }}>
    @if ($title || $description || $icon || isset($actions))
        <div class="flex flex-col gap-3 border-b border-border-soft px-5 py-4 sm:flex-row sm:items-start sm:justify-between sm:px-6">
            <div class="flex min-w-0 gap-3">
                @if ($icon)
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-brand-soft text-brand">
                        <i class="bi {{ $icon }}"></i>
                    </span>
                @endif
                <div class="min-w-0">
                    @if ($title)
                        <h2 class="text-base font-semibold text-content-main sm:text-lg">{{ $title }}</h2>
                    @endif
                    @if ($description)
                        <p class="mt-1 text-sm text-content-sub">{{ $description }}</p>
                    @endif
                </div>
            </div>

            @isset($actions)
                <div class="shrink-0">{{ $actions }}</div>
            @endisset
        </div>
    @endif

    <div class="{{ $padding }}">
        {{ $slot }}
    </div>
</section>
