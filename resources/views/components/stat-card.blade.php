@props(['title', 'value', 'icon', 'color', 'subtitle' => null])

@php
    $colors = [
        'purple' => 'bg-purple-500',
        'blue' => 'bg-blue-500',
        'green' => 'bg-green-500',
        'yellow' => 'bg-yellow-500',
        'red' => 'bg-red-500',
        'indigo' => 'bg-indigo-500',
    ];
    $bgColor = $colors[$color] ?? "bg-gray-500";
@endphp

<div class="bg-white overflow-hidden shadow rounded-lg">
    <div class="px-4 py-5 sm:p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 {{ $bgColor }} rounded-md p-3">
                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    {!! $icon !!}
                </svg>
            </div>
            <div class="ml-5 w-0 flex-1">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        {{ $title }}
                    </dt>
                    <dd class="flex items-baseline">
                        <div class="text-2xl font-semibold text-gray-900">
                            {{ $value }}
                        </div>
                        @if($subtitle)
                            <p class="ml-2 flex items-baseline text-sm font-semibold {{'text-' . $color . '-600'}}">
                                <span>{{ $subtitle }}</span>
                            </p>
                        @endif
                    </dd>
                </dl>
            </div>
        </div>
    </div>
</div>
