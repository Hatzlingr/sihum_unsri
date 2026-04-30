@props(['icon' => 'bi-stars'])

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-2 rounded-full bg-brand-soft px-4 py-2 text-xs font-black uppercase tracking-[0.18em] text-brand shadow-sm']) }}>
    <i class="bi {{ $icon }} text-sm"></i>
    {{ $slot }}
</span>
