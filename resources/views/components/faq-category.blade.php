@props(['icon', 'title', 'description' => null])

<div {{ $attributes->merge(['class' => 'rounded-[2rem] bg-bg-base p-6 shadow-sm']) }}>
    <div class="flex items-start gap-4">
        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-brand-soft text-brand">
            <i class="bi {{ $icon }} text-xl"></i>
        </div>
        <div>
            <h2 class="text-xl font-black text-content-main">{{ $title }}</h2>
            @if ($description)
                <p class="mt-2 text-sm leading-7 text-content-sub">{{ $description }}</p>
            @endif
        </div>
    </div>

    @if (trim($slot))
        <div class="mt-6 space-y-4">
            {{ $slot }}
        </div>
    @endif
</div>
