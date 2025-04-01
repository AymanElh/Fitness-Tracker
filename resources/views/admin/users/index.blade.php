<!-- resources/views/admin/users.blade.php -->
@extends('layouts.admin')

@section('title', 'Users')

@section('content')
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">User Management</h1>
            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                Add User
            </button>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-4 bg-gray-50 border-b flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <input type="text" placeholder="Search a user" class="border px-3 py-2 rounded-lg w-64">
                    <select class="border px-3 py-2 rounded-lg">
                        <option>Filter by status</option>
                        <option>Active</option>
                        <option>Inactive</option>
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
                        Name
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Email
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Goal
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @php
                    $users = [
                        [
                            'name' => 'Jean Dupont',
                            'email' => 'jean.dupont@exemple.com',
                            'goal' => 'Weight loss',
                            'status' => 'Active'
                        ],
                        [
                            'name' => 'Marie Leclerc',
                            'email' => 'marie.leclerc@exemple.com',
                            'goal' => 'Muscle gain',
                            'status' => 'Active'
                        ],
                        [
                            'name' => 'Paul Martin',
                            'email' => 'paul.martin@exemple.com',
                            'goal' => 'Endurance',
                            'status' => 'Inactive'
                        ]
                    ]
                @endphp

                @foreach($users as $user)
                    <tr>
                        <td class="px-4 py-3">
                            <input type="checkbox" class="rounded">
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center mr-3">
                                    {{ substr($user['name'], 0, 2) }}
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $user['name'] }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500">
                            {{ $user['email'] }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500">
                            {{ $user['goal'] }}
                        </td>
                        <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            {{ $user['status'] == 'Active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $user['status'] }}
                        </span>
                        </td>
                        <td class="px-4 py-3 flex space-x-2">
                            <button class="text-blue-600 hover:text-blue-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                            </button>
                            <button class="text-red-600 hover:text-red-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="p-4 bg-gray-50 border-t flex justify-between items-center">
            <span class="text-sm text-gray-600">
                Showing 1-3 of 3 users
            </span>
                <div class="space-x-2">
                    <button class="px-3 py-1 border rounded-lg hover:bg-gray-100">
                        Previous
                    </button>
                    <button class="px-3 py-1 border rounded-lg hover:bg-gray-100">
                        Next
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
