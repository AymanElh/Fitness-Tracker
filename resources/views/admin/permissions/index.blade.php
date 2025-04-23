@extends('layouts.admin')

@section('title', 'Permission Management')

@section('content')
    <div class="py-6">
        <div class="max-w-10~xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        Permission Management
                    </h2>
                    <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                      clip-rule="evenodd"/>
                            </svg>
                            Last updated: {{ date('F j, Y, g:i a', strtotime($currentDateTime)) }}
                        </div>
                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 005 10a6 6 0 0012 0c0-.35-.035-.69-.1-1.021A5 5 0 0010 11z"
                                      clip-rule="evenodd"/>
                            </svg>
                            Updated by: {{ $currentUser }}
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <button type="button"
                            onclick="openCreatePermissionModal()"
                            class="ml-3 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                             fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                  clip-rule="evenodd"/>
                        </svg>
                        Create New Permission
                    </button>
                </div>
            </div>

            <!-- Flash Messages -->
            @if(session('success'))
                <x-alert type="success" id="successAlert">
                    <p class="font-bold">Success!</p>
                    <p class="text-sm">{{ session('success') }}</p>
                </x-alert>
            @endif

            @if(session('error'))
                <x-alert type="error" id="errorAlert">
                    <p class="font-bold">Error!</p>
                    <p class="text-sm">{{ session('error') }}</p>
                </x-alert>
            @endif

            @if ($errors->any())
                <x-alert type="error" id="validationErrors">
                    <p class="font-bold">Please fix the following errors:</p>
                    <ul class="mt-1 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-alert>
            @endif
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-6">
                <!-- Total Permissions Card -->
                <x-stat-card
                    title="Total Permission"
                    value="{{ $totalPermissions }}"
                    color="purple"
                    icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />'
                />

                <!-- Module Coverage Card -->
                <x-stat-card
                    title="Module Coverage"
                    value="{{ $moduleCount }}"
                    color="green"
                    subtitle="modules"
                    icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />'
                />

                <!-- Assigned Permissions Card -->
                <x-stat-card
                    title="Assigned Roles"
                    value="{{ $totalAssignments }}"
                    color="blue"
                    subtitle="assignments"
                    icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />'
                />

                <!-- Custom Permissions Card -->
                <x-stat-card
                    title="Custom Permissions"
                    value="{{ $customPermissions }}"
                    subtitle="custom"
                    color="yellow"
                    icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />'
                />
            </div>

            <!-- Filter and Search Section -->
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="p-4">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-3 md:space-y-0">
                        <div class="w-full md:w-1/3">
                            <label for="permissionSearch" class="sr-only">Search</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                              d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <input type="text" name="permissionSearch" id="permissionSearch"
                                       class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md"
                                       placeholder="Search permissions...">
                            </div>
                        </div>

                        <div class="flex items-center space-x-3">
                            <select id="moduleFilter" name="moduleFilter"
                                    class="mt-1 block pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="">All Modules</option>
                                @php
                                    $modules = $permissions->pluck('module')->unique()->sort()->values()->all();
                                @endphp
                                @foreach($modules as $module)
                                    @if(!empty($module))
                                        <option value="{{ $module }}">{{ ucfirst($module) }}</option>
                                    @endif
                                @endforeach
                            </select>

                            <select id="sortPermissions" name="sortPermissions"
                                    class="mt-1 block pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="name_asc">Name (A-Z)</option>
                                <option value="name_desc">Name (Z-A)</option>
                                <option value="module_asc">Module (A-Z)</option>
                                <option value="created_desc">Newest First</option>
                                <option value="created_asc">Oldest First</option>
                                <option value="roles_desc">Most Used</option>
                                <option value="roles_asc">Least Used</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Permissions Table -->
            <div class="flex flex-col mb-6">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Module
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Description
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Used in Roles
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Created
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody id="permissionsTableBody" class="bg-white divide-y divide-gray-200">
                                @if($permissions->count() > 0)
                                    @foreach($permissions as $permission)
                                        <tr class="hover:bg-gray-50 permission-row"
                                            data-id="{{ $permission->id }}"
                                            data-name="{{ strtolower($permission->name) }}"
                                            data-module="{{ strtolower($permission->module ?? '') }}"
                                            data-roles="{{ $permission->roles_count }}"
                                            data-created="{{ $permission->created_at->timestamp ?? 0 }}">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div
                                                    class="text-sm font-medium text-gray-900">{{ $permission->name }}</div>
                                                <div class="text-xs text-gray-500">ID: {{ $permission->id }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($permission->module)
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                        @if($permission->module == 'dashboard') bg-green-100 text-green-800
                                                        @elseif($permission->module == 'users') bg-blue-100 text-blue-800
                                                        @elseif($permission->module == 'roles') bg-purple-100 text-purple-800
                                                        @elseif($permission->module == 'content') bg-yellow-100 text-yellow-800
                                                        @elseif($permission->module == 'reports') bg-red-100 text-red-800
                                                        @elseif($permission->module == 'settings') bg-gray-100 text-gray-800
                                                        @elseif($permission->module == 'api') bg-indigo-100 text-indigo-800
                                                        @else bg-gray-100 text-gray-800 @endif">
                                                        {{ ucfirst($permission->module) }}
                                                    </span>
                                                @else
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        Other
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900 max-w-xs">
                                                    {{ $permission->description ?? 'No description provided' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $permission->roles_count }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $permission->created_at ? $permission->created_at->format('Y-m-d') : 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex justify-end space-x-2">
                                                    <button type="button"
                                                            onclick="openEditPermissionModal({{ $permission->id }})"
                                                            class="text-indigo-600 hover:text-indigo-900">
                                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                                        </svg>
                                                    </button>
                                                    <button type="button"
                                                            onclick="openDeletePermissionModal({{ $permission->id }}, '{{ $permission->name }}')"
                                                            class="text-red-600 hover:text-red-900 {{ $permission->roles_count > 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                        {{$permission->roles_count > 0 ? 'disabled' : '' }}>
                                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none"
                                                 stroke="currentColor" viewBox="0 0 24 24"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <h3 class="mt-2 text-sm font-medium text-gray-900">No permissions found</h3>
                                            <p class="mt-1 text-sm text-gray-500">Get started by creating a new
                                                permission.</p>
                                            <div class="mt-6">
                                                <button type="button" onclick="openCreatePermissionModal()"
                                                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                         viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                              d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                                              clip-rule="evenodd"/>
                                                    </svg>
                                                    New Permission
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                @if($permissions->count() > 0)
                    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                        <div class="flex-1 flex justify-between sm:hidden">
                            <a href="#"
                               class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Previous
                            </a>
                            <a href="#"
                               class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Next
                            </a>
                        </div>
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Showing
                                    <span class="font-medium">1</span>
                                    to
                                    <span class="font-medium">{{ min($permissions->count(), 10) }}</span>
                                    of
                                    <span class="font-medium">{{ $permissions->count() }}</span>
                                    results
                                </p>
                            </div>
                            @if($permissions->count() > 10)
                                <div>
                                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                                         aria-label="Pagination">
                                        <a href="#"
                                           class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                            <span class="sr-only">Previous</span>
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                 fill="currentColor">
                                                <path fill-rule="evenodd"
                                                      d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                                      clip-rule="evenodd"/>
                                            </svg>
                                        </a>
                                        <a href="#" aria-current="page"
                                           class="z-10 bg-indigo-50 border-indigo-500 text-indigo-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                            1
                                        </a>
                                        <a href="#"
                                           class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                            <span class="sr-only">Next</span>
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                 fill="currentColor">
                                                <path fill-rule="evenodd"
                                                      d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                      clip-rule="evenodd"/>
                                            </svg>
                                        </a>
                                    </nav>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Create Permission Modal -->
    <x-modal id="createPermissionModal" title="Create New Permission" iconType="create">
        <form action="{{ route('admin.permissions.store') }}" method="post">
            @csrf
            <div class="mt-6 space-y-6">
                <div>
                    <label for="permission_name" class="block text-sm font-medium text-gray-700">Permission Name</label>
                    <div class="mt-1">
                        <input type="text" name="name" id="permission_name"
                               class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                               placeholder="e.g. manage_content">
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Use snake_case format (e.g. view_dashboard, edit_users)</p>
                </div>

                <div>
                    <label for="module" class="block text-sm font-medium text-gray-700">Module</label>
                    <div class="mt-1">
                        <select id="module" name="module"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            <option value="">Select Module</option>
                            <option value="dashboard">Dashboard</option>
                            <option value="users">Users</option>
                            <option value="roles">Roles</option>
                            <option value="permissions">Permissions</option>
                            <options value="meals">Meals</options>
                            <option value="exercises">Exercises</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <div class="mt-1">
                        <textarea id="description" name="description" rows="3"
                                  class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                  placeholder="Describe what this permission allows"></textarea>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 px-4 py-3 mt-6 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Create Permission
                </button>
                <button type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                        onclick="closeCreatePermissionModal()">
                    Cancel
                </button>
            </div>
        </form>
    </x-modal>

    <!-- Edit Permission Modal -->
    <x-modal id="editPermissionModal" title="Edit Permission" icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />'>
        <form id="updatePermissionForm" action="" method="post">
            @csrf
            @method('PUT')
            <div class="mt-6 space-y-6">
                <input type="hidden" name="permission_id" id="edit_permission_id">

                <div>
                    <label for="edit_permission_name" class="block text-sm font-medium text-gray-700">Permission
                        Name</label>
                    <div class="mt-1">
                        <input type="text" name="name" id="edit_permission_name"
                               class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Use snake_case format (e.g. view_dashboard, edit_users)</p>
                </div>

                <div>
                    <label for="edit_module" class="block text-sm font-medium text-gray-700">Module</label>
                    <div class="mt-1">
                        <select id="edit_module" name="module"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            <option value="">Select Module</option>
                            <option value="dashboard">Dashboard</option>
                            <option value="users">Users</option>
                            <option value="roles">Roles</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="edit_description" class="block text-sm font-medium text-gray-700">Description</label>
                    <div class="mt-1">
                        <textarea id="edit_description" name="description" rows="3"
                                  class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
                    </div>
                </div>

                <div id="is_core_locked_notice" class="hidden mt-4 p-4 bg-yellow-50 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                 fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 px-4 py-3 mt-6 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Update Permission
                </button>
                <button type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                        onclick="closeEditPermissionModal()">
                    Cancel
                </button>
            </div>
        </form>
    </x-modal>

    <!-- Delete Permission modal -->
    <x-modal id="deletePermissionModal" title="Delete Permission" iconType="delete">
        <div class="mt-2">
            <p class="text-sm text-gray-500" id="delete-permission-text">
                Are you sure you want to delete this permission? This action cannot be undone.
            </p>
            <p class="mt-2 text-sm text-red-500">
                Warning: Deleting this permission will remove it permanently from the system.
            </p>
        </div>

        <div class="bg-gray-50 px-4 py-3 mt-6 sm:px-6 sm:flex sm:flex-row-reverse">
            <form id="deletePermissionFormActual" action="" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Delete
                </button>
            </form>
            <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="closeDeletePermissionModal()">
                Cancel
            </button>
        </div>
    </x-modal>

    <div id="deletePermissionModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title"
         role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div id="deletePermissionForm">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="delete-modal-title">
                                    Delete Permission
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500" id="delete-permission-text">
                                        Are you sure you want to delete this permission? This action cannot be undone.
                                    </p>
                                    <p class="mt-2 text-sm text-red-500">
                                        Warning: Deleting this permission will remove it permanently from the system.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <form id="deletePermissionFormActual" action="" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Delete
                            </button>
                        </form>
                        <button type="button"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                                onclick="closeDeletePermissionModal()">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS Script -->
    <script>
        // all permission json
        const permissions = @json($permissions);

        // Open and close the create Permission Modal
        function openCreatePermissionModal() {
            document.getElementById('createPermissionModal').classList.remove('hidden');
        }

        function closeCreatePermissionModal() {
            document.getElementById('createPermissionModal').classList.add('hidden');
        }

        // Open and Close edit permission Modal
        function openEditPermissionModal(permissionId) {
            const permission = permissions.find(p => p.id === permissionId);
            if (!permission) return;
            console.log(permission);
            document.getElementById('edit_permission_name').value = permission.name;
            document.getElementById('edit_module').value = permission.module || '';
            document.getElementById('edit_description').value = permission.description;

            document.getElementById('updatePermissionForm').action = `{{ url("admin/permissions") }}/${permissionId}`
            document.getElementById('edit_permission_id').value = permissionId;
            document.getElementById('editPermissionModal').classList.remove('hidden');
        }

        function closeEditPermissionModal() {
            document.getElementById('editPermissionModal').classList.add('hidden');
        }

        // open and close delete permission modal
        function openDeletePermissionModal(permissionId, permissionName) {
            const permission = permissions.find(p => p.id === permissionId);
            if (!permission) return;

            if (permission.roles_count > 0) {
                alert('Cannot delete a permission that is assigned to roles.');
                return;
            }

            document.getElementById('delete-permission-text').textContent = `Are you sure you want to delete the permission "${permissionName}"? This action cannot be undone.`;
            document.getElementById('deletePermissionFormActual').action = `{{ url('/admin/permissions') }}/${permissionId}`;
            document.getElementById('deletePermissionModal').classList.remove('hidden');
        }

        function closeDeletePermissionModal() {
            document.getElementById('deletePermissionModal').classList.add('hidden');
        }

        // Close modals when clicking outside
        window.onclick = function (event) {
            // console.log(event);
            const createModal = document.getElementById('createPermissionModal');
            const editModal = document.getElementById('editPermissionModal');
            const deleteModal = document.getElementById('deletePermissionModal');
            // console.log(createModal);
            if (event.target === createModal) {
                // console.log("create modal");
                closeCreatePermissionModal();
            } else if (event.target === editModal) {
                closeEditPermissionModal();
            } else if (event.target === deleteModal) {
                closeDeletePermissionModal();
            }
        }

        // search
        document.getElementById("permissionSearch").addEventListener('input', function (e) {
            const searchField = e.target.value.toLocaleLowerCase();
            // console.log("Search Field: ", searchField);
            filterPermissions();
        });

        document.getElementById("moduleFilter").addEventListener("change", function(e) {
            filterPermissions();
        });

        // Sort functionality
        document.getElementById('sortPermissions').addEventListener('change', function (e) {
            sortPermissions();
        });

        // Filter Permissions
        function filterPermissions() {
            const searchTerm = document.getElementById("permissionSearch").value.toLowerCase();
            const moduleFilter = document.getElementById('moduleFilter').value.toLowerCase();
            const rows = document.querySelectorAll('.permission-row');
            console.log("Module Filter: ", rows);
            rows.forEach(row => {
                const name = row.getAttribute('data-name');
                const module = row.getAttribute('data-module');

                const description = row.querySelector('td:nth-child(3) div').textContent.toLowerCase();

                const matchedSearch = name.includes(searchTerm) || description.includes(searchTerm);

                const matchesModule = !moduleFilter || (module && module === moduleFilter);
                console.log(matchesModule);

                if (matchedSearch && matchesModule) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            })
        }

        // sorting
        function sortPermissions() {
            const sortOption = document.getElementById('sortPermissions').value;
            const tbody = document.getElementById('permissionsTableBody');
            // console.log(tbody);
            const rows = Array.from(tbody.querySelectorAll('.permission-row'));
            // console.log(rows);

            rows.sort((a, b) => {
                switch (sortOption) {
                    case 'name_asc':
                        return a.getAttribute('data-name').localeCompare(b.getAttribute('data-name'));
                    case 'name_desc':
                        return b.getAttribute('data-name').localeCompare(a.getAttribute('data-name'));
                    case 'module_asc':
                        return (a.getAttribute('data-module') || '').localeCompare(b.getAttribute('data-module') || '');
                    case 'created_desc':
                        return parseInt(b.getAttribute('data-created')) - parseInt(a.getAttribute('data-created'));
                    case 'created_asc':
                        return parseInt(a.getAttribute('data-created')) - parseInt(b.getAttribute('data-created'));
                    case 'roles_desc':
                        return parseInt(b.getAttribute('data-roles')) - parseInt(a.getAttribute('data-roles'));
                    case 'roles_asc':
                        return parseInt(a.getAttribute('data-roles')) - parseInt(b.getAttribute('data-roles'));
                    default:
                        return 0;
                }
            });

            // Remove existing rows
            rows.forEach(row => row.remove());

            // Append sorted rows
            rows.forEach(row => tbody.appendChild(row));
        }

        // Initialize filtering and sorting
        document.addEventListener('DOMContentLoaded', function () {
            // Auto hide flash messages after 5 seconds
            setTimeout(function () {
                const successAlert = document.getElementById('successAlert');
                const errorAlert = document.getElementById('errorAlert');
                const validationErrors = document.getElementById('validationErrors');

                if (successAlert) successAlert.remove();
                if (errorAlert) errorAlert.remove();
                if (validationErrors) validationErrors.remove();
            }, 10000);

            // Apply initial sorting
            sortPermissions();
        });
    </script>
@endsection
