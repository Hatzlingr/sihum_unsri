@props(['icon', 'title', 'description'])

<div {{ $attributes->merge(['class' => 'group rounded-[2rem] bg-bg-base p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl']) }}>
    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-soft text-brand transition duration-300 group-hover:scale-105">
        <i class="bi {{ $icon }} text-2xl"></i>
    </div>
    <h3 class="mt-6 text-lg font-black text-content-main">{{ $title }}</h3>
    <p class="mt-3 text-sm leading-7 text-content-sub">{{ $description }}</p>
</div>
