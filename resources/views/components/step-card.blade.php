@props(['number', 'title', 'description', 'icon' => null])

<div {{ $attributes->merge(['class' => 'rounded-[2rem] bg-bg-base p-7 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl']) }}>
    <div class="flex items-center justify-between gap-4">
        <span class="text-4xl font-black tracking-tight text-brand-soft">{{ $number }}</span>
        @if ($icon)
            <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-brand-soft text-brand">
                <i class="bi {{ $icon }}"></i>
            </span>
        @endif
    </div>
    <h3 class="mt-6 text-lg font-black text-content-main">{{ $title }}</h3>
    <p class="mt-3 text-sm leading-7 text-content-sub">{{ $description }}</p>
</div>
