@props([
    'rows' => 8,
    'height' => 'h-11',
])

<div {{ $attributes->class('space-y-3') }}>
    @for ($i = 0; $i < $rows; $i++)
        <div class="{{ $height }} rounded-2xl bg-content-sub/35"></div>
    @endfor
</div>
