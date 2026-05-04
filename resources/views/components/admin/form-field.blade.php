@props([
    'label',
    'name',
    'type' => 'text',
    'placeholder' => null,
    'value' => null,
])

<label class="block">
    <span class="text-sm font-semibold text-content-main">{{ $label }}</span>
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder ?? $label }}"
        {{ $attributes->class('mt-2 h-11 w-full rounded-2xl border border-border-soft bg-bg-surface px-4 text-sm outline-none transition placeholder:text-content-sub/70 focus:border-brand focus:bg-bg-base focus:ring-4 focus:ring-brand-soft') }}
    >
    @error($name)
        <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
    @enderror
</label>
