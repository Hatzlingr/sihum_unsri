@props([
    'overline' => null,
    'title',
    'description' => null,
    'href' => '#',
    'buttonText' => 'Mulai Sekarang',
    'icon' => 'bi-arrow-right',
])

<div {{ $attributes->merge(['class' => 'relative overflow-hidden rounded-[2.5rem] bg-brand p-8 shadow-xl shadow-brand/20 md:p-12']) }}>
    <div class="absolute -right-16 -top-16 h-56 w-56 rounded-full bg-white/10 blur-2xl"></div>
    <div class="absolute -bottom-20 left-12 h-64 w-64 rounded-full bg-brand-soft/20 blur-3xl"></div>

    <div class="relative z-10 flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between">
        <div class="max-w-2xl">
            @if ($overline)
                <p class="text-sm font-black uppercase tracking-[0.22em] text-brand-soft">{{ $overline }}</p>
            @endif
            <h2 class="mt-3 text-3xl font-black tracking-tight text-white md:text-4xl">{{ $title }}</h2>
            @if ($description)
                <p class="mt-4 text-sm leading-7 text-white/80 md:text-base">{{ $description }}</p>
            @endif
        </div>

        <a href="{{ $href }}" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-2xl bg-white px-7 py-4 text-sm font-black text-brand shadow-lg transition duration-300 hover:-translate-y-0.5 hover:bg-brand-soft hover:shadow-xl">
            {{ $buttonText }}
            <i class="bi {{ $icon }}"></i>
        </a>
    </div>
</div>
