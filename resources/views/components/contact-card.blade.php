@props(['icon', 'title', 'description', 'detail' => null])

<div {{ $attributes->merge(['class' => 'rounded-[2rem] bg-bg-base p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl']) }}>
    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-soft text-brand">
        <i class="bi {{ $icon }} text-2xl"></i>
    </div>
    <h3 class="mt-6 text-lg font-black text-content-main">{{ $title }}</h3>
    <p class="mt-3 text-sm leading-7 text-content-sub">{{ $description }}</p>
    @if ($detail)
        <p class="mt-5 inline-flex rounded-full bg-bg-surface px-4 py-2 text-sm font-bold text-brand shadow-sm">{{ $detail }}</p>
    @endif
</div>
