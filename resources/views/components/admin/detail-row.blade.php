@props([
    'label',
    'value' => null,
])

<div {{ $attributes->class('space-y-1') }}>
    <p class="text-xs font-semibold uppercase tracking-wide text-content-sub">{{ $label }}</p>
    <p class="text-sm font-medium text-content-main">{{ $value ?? $slot }}</p>
</div>
