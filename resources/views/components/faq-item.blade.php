@props(['question', 'answer'])

<div x-data="{ open: false }" {{ $attributes->merge(['class' => 'rounded-3xl bg-bg-surface p-5 shadow-sm']) }}>
    <button type="button" class="flex w-full items-center justify-between gap-4 text-left" @click="open = !open">
        <span class="text-sm font-black text-content-main md:text-base">{{ $question }}</span>
        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-2xl bg-bg-base text-content-sub shadow-sm transition" :class="open ? 'text-brand' : ''">
            <i class="bi bi-chevron-down transition duration-300" :class="open ? 'rotate-180' : ''"></i>
        </span>
    </button>

    <div x-show="open">
        <p class="mt-4 text-sm leading-7 text-content-sub">{{ $answer }}</p>
    </div>
</div>
