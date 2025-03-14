@extends('layouts.admin')

@section('title', 'Créer un Utilisateur')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    <div class="max-w-3xl mx-auto">
        <!-- Back button -->
        <div class="mb-6">
            <a href="#" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Retour aux utilisateurs
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <!-- Form Header -->
            <div class="border-b border-gray-100 px-8 py-6">
                <h1 class="text-2xl font-bold text-gray-900">Créer un Utilisateur</h1>
                <p class="mt-2 text-sm text-gray-600">Remplissez les informations pour ajouter un nouvel utilisateur.</p>
            </div>

            <form action="#" method="POST" class="px-8 py-6">
                @csrf
                
                <div class="space-y-8">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- First Name -->
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700">Prénom</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="text" name="first_name" id="first_name" 
                                    class="block w-full rounded-md border-gray-300 pr-10 focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    placeholder="Jean">
                            </div>
                        </div>

                        <!-- Last Name -->
                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700">Nom</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="text" name="last_name" id="last_name" 
                                    class="block w-full rounded-md border-gray-300 pr-10 focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    placeholder="Dupont">
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="sm:col-span-2">
                            <label for="email" class="block text-sm font-medium text-gray-700">Adresse Email</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="email" name="email" id="email" 
                                    class="block w-full rounded-md border-gray-300 pr-10 focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    placeholder="jean.dupont@exemple.com">
                            </div>
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="password" name="password" id="password" 
                                    class="block w-full rounded-md border-gray-300 pr-10 focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    placeholder="••••••••">
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer le mot de passe</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="password" name="password_confirmation" id="password_confirmation" 
                                    class="block w-full rounded-md border-gray-300 pr-10 focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    placeholder="••••••••">
                            </div>
                        </div>

                        <!-- User Role -->
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700">Rôle</label>
                            <select name="role" id="role" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <option value="utilisateur">Utilisateur</option>
                                <option value="admin">Administrateur</option>
                                <option value="coach">Coach</option>
                            </select>
                        </div>

                        <!-- Account Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Statut du compte</label>
                            <select name="status" id="status" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <option value="actif">Actif</option>
                                <option value="inactif">Inactif</option>
                                <option value="suspendu">Suspendu</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-8 border-t border-gray-200 pt-6 flex justify-end space-x-3">
                    <button type="button" 
                        class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        Annuler
                    </button>
                    <button type="submit" 
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        Créer l'utilisateur
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection