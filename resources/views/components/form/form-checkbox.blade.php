@props(['name', 'id' => null, 'checked' => false, 'value' => null])

<div class="flex items-center">
    <input
        type="checkbox"
        name="{{ $name }}"
        id="{{ $id ?? $name }}"
        value="{{ $value ?? 1 }}"
        {{ old($name, $checked) ? 'checked' : '' }}
        {{ $attributes->merge([
            'class' => 'h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded transition-colors duration-300'
        ]) }}
    />
</div>
