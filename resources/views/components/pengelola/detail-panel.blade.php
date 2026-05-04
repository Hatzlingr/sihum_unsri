@props([
    'title' => 'Detail',
    'icon' => null,
])

<aside {{ $attributes->class('overflow-hidden rounded-3xl border border-border-soft bg-bg-base shadow-sm') }}>
    <div class="border-b border-border-soft px-5 py-4 sm:px-6">
        <div class="flex items-center gap-3">
            @if ($icon)
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-brand-soft text-brand">
                    <i class="bi {{ $icon }}"></i>
                </span>
            @endif
            <h2 class="text-base font-semibold text-content-main sm:text-lg">{{ $title }}</h2>
        </div>
    </div>

    <div class="p-5 sm:p-6">
        {{ $slot }}
    </div>

    @isset($actions)
        <div class="border-t border-border-soft px-5 py-4 sm:px-6">
            {{ $actions }}
        </div>
    @endisset
</aside>
