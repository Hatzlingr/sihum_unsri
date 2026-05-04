@props([
    'href' => null,
    'type' => 'button',
    'variant' => 'primary',
    'icon' => null,
])

@php
    $classes = match ($variant) {
        'secondary' => 'border-border-soft bg-bg-base text-content-main hover:border-brand hover:bg-brand-light hover:text-brand',
        'danger' => 'border-red-200 bg-red-50 text-red-700 hover:bg-red-100',
        'muted' => 'border-border-soft bg-bg-surface text-content-sub hover:bg-brand-light hover:text-brand',
        'dark' => 'border-content-main bg-content-main text-white hover:bg-brand hover:border-brand',
        default => 'border-brand bg-brand text-white hover:bg-brand/90',
    };
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class("inline-flex items-center justify-center gap-2 rounded-2xl border px-4 py-2.5 text-sm font-semibold transition {$classes}") }}>
        @if ($icon)<i class="bi {{ $icon }}"></i>@endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->class("inline-flex items-center justify-center gap-2 rounded-2xl border px-4 py-2.5 text-sm font-semibold transition {$classes}") }}>
        @if ($icon)<i class="bi {{ $icon }}"></i>@endif
        {{ $slot }}
    </button>
@endif
