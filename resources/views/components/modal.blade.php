@props(['id', 'title', 'iconType' => 'create', 'iconColor', 'maxWidth' => 'lg', 'submitText' => 'Save'])

@php
    $maxWidthClass = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
    ][$maxWidth];

    $iconsPath = [
        'create' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />',
        'edit' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />',
        'delete' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />'
    ];

    $colors = [
        'create' => 'indigo',
        'edit' => 'yellow',
        'delete' => 'red'
    ];

    $color = $iconColor ?? $colors[$iconType];

    $iconPath = $iconsPath[$iconType];
@endphp

<div id="{{ $id }}" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <!-- Modal position trick -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Modal content -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle {{ $maxWidthClass }} sm:w-full">
            <!-- Modal header (if provided) -->
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                @if(isset($header))
                    <div class="sm:flex sm:items-start">
                        {{ $header }}
                    </div>
                @else
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-{{ $color }}-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-{{ $color }}-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                {!! $iconPath !!}
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                {{ $title }}
                            </h3>
                            {{ $slot }}
                        </div>
                    </div>
                @endif
            </div>

            <!-- Modal footer -->
            @if(isset($footer))
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>
