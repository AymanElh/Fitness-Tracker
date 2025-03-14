@extends('layouts.admin')

@section('title', 'Exercices')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Gestion des Exercices</h1>
        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            Ajouter un Exercice
        </button>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-4 bg-gray-50 border-b flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <input type="text" placeholder="Rechercher un exercice" class="border px-3 py-2 rounded-lg w-64">
                <select class="border px-3 py-2 rounded-lg">
                    <option>Filtrer par catégorie</option>
                    <option>Cardio</option>
                    <option>Musculation</option>
                    <option>Étirement</option>
                </select>
            </div>
        </div>

        <table class="w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <input type="checkbox" class="rounded">
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Nom
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Catégorie
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Difficulté
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Durée
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @php
                $exercises = [
                    [
                        'name' => 'Pompes',
                        'category' => 'Musculation',
                        'difficulty' => 'Intermédiaire',
                        'duration' => '15 min'
                    ],
                    [
                        'name' => 'Course à pied',
                        'category' => 'Cardio',
                        'difficulty' => 'Débutant',
                        'duration' => '30 min'
                    ],
                    [
                        'name' => 'Yoga matinal',
                        'category' => 'Étirement',
                        'difficulty' => 'Tous niveaux',
                        'duration' => '20 min'
                    ]
                ]
                @endphp

                @foreach($exercises as $exercise)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <input type="checkbox" class="rounded">
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center">
                            <div class="text-sm font-medium text-gray-900">{{ $exercise['name'] }}</div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-500">
                        {{ $exercise['category'] }}
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-500">
                        {{ $exercise['difficulty'] }}
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-500">
                        {{ $exercise['duration'] }}
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex space-x-2">
                            <button class="text-blue-600 hover:text-blue-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </button>
                            <button class="text-red-600 hover:text-red-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="p-4 bg-gray-50 border-t flex justify-between items-center">
            <span class="text-sm text-gray-600">
                Affichage de 1-3 sur 3 exercices
            </span>
            <div class="space-x-2">
                <button class="px-3 py-1 border rounded-lg hover:bg-gray-100">
                    Précédent
                </button>
                <button class="px-3 py-1 border rounded-lg hover:bg-gray-100">
                    Suivant
                </button>
            </div>
        </div>
    </div>
</div>
@endsection