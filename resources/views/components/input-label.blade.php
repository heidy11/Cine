@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-[#ffd700]']) }}>
    {{ $value ?? $slot }}
</label>
