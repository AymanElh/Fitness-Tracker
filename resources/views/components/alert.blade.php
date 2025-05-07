@props(['type' => 'info', 'dismissable' => true, 'id' => null])

@php
    $types = [
        'success' => 'bg-green-100 border-green-500 text-green-700',
        'error' => 'bg-red-100 border-red-500 text-red-700',
        'warning' => 'bg-yellow-100 border-yellow-500 text-yellow-700',
        'info' => 'bg-blue-100 border-blue-500 text-blue-700',
    ];

    $icons = [
        'success' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />',
        'error' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />',
        'warning' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />',
        'info' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />',
    ];

    $alertId = $id ?? 'alert-' . rand(1000, 9999);
    $alertClass = $types[$type] ?? $types['info'];
    $iconPath = $icons[$type] ?? $icons['info'];
//    dd($iconPath);
@endphp

<div id="{{ $alertId }}" class=" {{ $alertClass }} mb-4 p-4 rounded shadow-sm border-l-4">
    <div class="flex items-center">
        <div class="py-1">
            <svg class="h-6 w-6 mr-4 {{ 'text-' . $type . '-500' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                {!! $iconPath !!}
            </svg>
        </div>
        <div class="flex-grow">
            {{ $slot }}
        </div>
        @if($dismissable)
            <button onclick="document.getElementById('{{ $alertId }}').remove()" class="ml-auto">
                <svg class="h-4 w-4 {{ 'text-' . $type . '-700' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        @endif
    </div>
</div>
