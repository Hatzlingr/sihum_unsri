@props(['icon', 'title', 'description' => null])

<div {{ $attributes->merge(['class' => 'rounded-3xl bg-bg-surface p-5 text-center shadow-sm']) }}>
    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-bg-base text-brand shadow-sm">
        <i class="bi {{ $icon }} text-xl"></i>
    </div>
    <h3 class="mt-4 text-sm font-black text-content-main">{{ $title }}</h3>
    @if ($description)
        <p class="mt-2 text-xs leading-6 text-content-sub">{{ $description }}</p>
    @endif
</div>
