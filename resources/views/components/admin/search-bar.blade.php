@props([
    'name' => 'q',
    'placeholder' => 'Cari data',
    'value' => null,
    'action' => null,
    'method' => 'GET',
])

<form method="{{ $method }}" action="{{ $action ?? url()->current() }}" {{ $attributes->class('flex flex-col gap-3 sm:flex-row sm:items-center') }}>
    <label class="relative min-w-0 flex-1">
        <span class="sr-only">{{ $placeholder }}</span>
        <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-content-sub"></i>
        <input
            type="search"
            name="{{ $name }}"
            value="{{ $value ?? request($name) }}"
            placeholder="{{ $placeholder }}"
            class="h-12 w-full rounded-2xl border border-border-soft bg-bg-base pl-11 pr-4 text-sm outline-none transition placeholder:text-content-sub/70 focus:border-brand focus:ring-4 focus:ring-brand-soft"
        >
    </label>

    {{ $slot }}
</form>
