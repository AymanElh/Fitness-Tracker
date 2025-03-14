@extends('layouts.admin')

@section('title', 'Ajouter un Exercice')

@section('content')
<div class="p-6 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <div class="max-w-4xl mx-auto">
        <!-- Back button -->
        <div class="mb-6">
            <a href="#" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Retour aux exercices
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden transform transition-all duration-300 hover:scale-[1.01]">
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 text-white p-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-extrabold mb-2 tracking-tight">Ajouter un Exercice</h1>
                        <p class="text-sm opacity-80">Créez un nouvel exercice en remplissant les informations ci-dessous.</p>
                    </div>
                </div>
            </div>

            <form action="#" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Exercise Name -->
                    <div class="col-span-2">
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nom de l'exercice</label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name"
                            placeholder="Ex: Pompes" 
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 hover:border-blue-300"
                        >
                    </div>

                    <!-- Description -->
                    <div class="col-span-2">
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                        <textarea 
                            name="description" 
                            id="description"
                            rows="4" 
                            placeholder="Décrivez l'exercice et son exécution..."
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 hover:border-blue-300"
                        ></textarea>
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">Catégorie</label>
                        <div class="relative">
                            <select 
                                name="category" 
                                id="category"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl appearance-none bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="">Sélectionnez une catégorie</option>
                                <option value="cardio">Cardio</option>
                                <option value="musculation">Musculation</option>
                                <option value="flexibility">Flexibilité</option>
                                <option value="endurance">Endurance</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Difficulty -->
                    <div>
                        <label for="difficulty" class="block text-sm font-semibold text-gray-700 mb-2">Niveau de difficulté</label>
                        <div class="relative">
                            <select 
                                name="difficulty" 
                                id="difficulty"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl appearance-none bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="debutant">Débutant</option>
                                <option value="intermediaire">Intermédiaire</option>
                                <option value="avance">Avancé</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Duration -->
                    <div>
                        <label for="duration" class="block text-sm font-semibold text-gray-700 mb-2">Durée (minutes)</label>
                        <div class="relative">
                            <input 
                                type="number" 
                                name="duration"
                                id="duration"
                                min="1" 
                                placeholder="15"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent pr-12"
                            >
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-500">min</div>
                        </div>
                    </div>

                    <!-- Calories -->
                    <div>
                        <label for="calories" class="block text-sm font-semibold text-gray-700 mb-2">Calories brûlées</label>
                        <div class="relative">
                            <input 
                                type="number" 
                                name="calories"
                                id="calories"
                                min="0" 
                                placeholder="100"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent pr-12"
                            >
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-500">kcal</div>
                        </div>
                    </div>

                    <!-- Video Upload -->
                    <div class="col-span-2">
                        <label for="video" class="block text-sm font-semibold text-gray-700 mb-2">Vidéo démonstrative</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-blue-400 transition-all group">
                            <svg class="mx-auto h-16 w-16 text-gray-400 group-hover:text-blue-500 transition-colors mb-4" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" 
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="text-sm text-gray-600">
                                <label class="relative cursor-pointer text-blue-600 hover:text-blue-700 font-semibold">
                                    Télécharger une vidéo
                                    <input 
                                        type="file" 
                                        name="video" 
                                        id="video"
                                        class="hidden" 
                                        accept="video/*"
                                    >
                                </label>
                                <p class="mt-1 text-xs text-gray-500">MP4, WebM jusqu'à 50MB</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a 
                        href="#" 
                        class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-100 transition-colors"
                    >
                        Annuler
                    </a>
                    <button 
                        type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl hover:scale-[1.03] transform transition-all hover:shadow-xl"
                    >
                        Créer l'exercice
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection