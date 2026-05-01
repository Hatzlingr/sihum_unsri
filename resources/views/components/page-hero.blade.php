@props([
    'badge' => null,
    'badgeIcon' => 'bi-stars',
    'title',
    'description' => null,
    'align' => 'center',
])

<section {{ $attributes->merge(['class' => 'relative overflow-hidden bg-bg-base px-5 py-16 md:py-24']) }}>
    <div class="absolute left-1/2 top-0 -z-10 h-80 w-80 -translate-x-1/2 rounded-full bg-brand-soft/70 blur-3xl md:h-112 md:w-"></div>

    <div @class([
        'mx-auto max-w-4xl',
        'text-center' => $align === 'center',
        'text-left' => $align === 'left',
    ])>
        @if ($badge)
            <x-section-badge :icon="$badgeIcon">{{ $badge }}</x-section-badge>
        @endif

        <h1 class="mt-6 text-4xl font-black tracking-tight text-content-main md:text-5xl lg:text-6xl">
            {{ $title }}
        </h1>

        @if ($description)
            <p @class([
                'mt-6 text-base leading-8 text-content-sub md:text-lg',
                'mx-auto max-w-2xl' => $align === 'center',
                'max-w-2xl' => $align === 'left',
            ])>
                {{ $description }}
            </p>
        @endif

        @if (trim($slot))
            <div class="mt-8">
                {{ $slot }}
            </div>
        @endif
    </div>
</section>
