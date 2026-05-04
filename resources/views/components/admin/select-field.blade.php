@props([
    'label',
    'name',
    'options' => [],
    'value' => null,
    'placeholder' => 'Pilih data',
])

<label class="block">
    <span class="text-sm font-semibold text-content-main">{{ $label }}</span>
    <select
        name="{{ $name }}"
        {{ $attributes->class('mt-2 h-11 w-full rounded-2xl border border-border-soft bg-bg-surface px-4 text-sm outline-none transition focus:border-brand focus:bg-bg-base focus:ring-4 focus:ring-brand-soft') }}
    >
        <option value="">{{ $placeholder }}</option>
        @foreach ($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" @selected(old($name, $value) == $optionValue)>{{ $optionLabel }}</option>
        @endforeach
    </select>
    @error($name)
        <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
    @enderror
</label>
