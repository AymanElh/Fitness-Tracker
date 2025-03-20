@props(['type' => 'submit', 'variant' => 'primary'])

@php
    $variantClasses = [
        'primary' => 'bg-indigo-600 hover:bg-indigo-700 text-white',
        'secondary' => 'bg-gray-200 hover:bg-gray-300 text-gray-800',
        'danger' => 'bg-red-600 hover:bg-red-700 text-white',
        'outline' => 'bg-white hover:bg-gray-50 text-gray-700 border border-gray-300',
    ][$variant];
@endphp

<button
    type="{{ $type }}"
    {{ $attributes->merge([
        'class' => 'animated-button w-full px-3 py-3 text-lg flex justify-center items-center py-2 px-4 rounded-lg shadow-sm text-sm font-bold transition-all duration-300 ' . $variantClasses
    ]) }}
>
    {{ $slot }}
</button>
