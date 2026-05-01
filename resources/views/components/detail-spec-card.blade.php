@props(['icon', 'label', 'value'])

<div {{ $attributes->merge(['class' => 'rounded-3xl bg-bg-base p-5 shadow-sm']) }}>
    <div class="flex items-center gap-4">
        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-brand-soft text-brand">
            <i class="bi {{ $icon }}"></i>
        </div>
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.16em] text-content-sub">{{ $label }}</p>
            <p class="mt-1 text-sm font-black text-content-main">{{ $value }}</p>
        </div>
    </div>
</div>
