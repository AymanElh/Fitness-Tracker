@extends('layouts.admin')

@section('title', 'Role Management')

@section('content')
    <div class="py-6">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        Role Management
                    </h2>
                    <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                      clip-rule="evenodd"/>
                            </svg>
                            Last updated: {{ date('F j, Y, g:i a') }}
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <button type="button"
                            onclick="openCreateRoleModal()"
                            class="ml-3 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                             fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                  clip-rule="evenodd"/>
                        </svg>
                        Create New Role
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

            <!-- Stats Section -->
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 mb-6">
                <!-- Total Roles Card -->
                <x-stat-card
                    title="Total Roles"
                    value="{{ $totalRoles }}"
                    color="indigo"
                    icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>'
                />

                <!-- Users with Roles Card -->
                <x-stat-card
                    title="Users with Roles"
                    value="{{ $totalUsers }}"
                    color="green"
                    icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>'
                />

                <!-- Permissions Card -->
                <x-stat-card
                    title="Total Permissions"
                    value="{{ $totalPermissions }}"
                    color="yellow"
                    icon=' <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>'
                />
            </div>

            <!-- Search and Filter Section -->
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="p-4">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-3 md:space-y-0">
                        <div class="w-full md:w-1/3">
                            <label for="search" class="sr-only">Search</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                              d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <input type="text" name="search" id="roleSearch"
                                       class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md"
                                       placeholder="Search roles...">
                            </div>
                        </div>

                        <div class="flex items-center space-x-2">
                            <label for="sortRoles" class="text-sm font-medium text-gray-700">Sort by:</label>
                            <select id="sortRoles" name="sort"
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="name_asc">Name (A-Z)</option>
                                <option value="name_desc">Name (Z-A)</option>
                                <option value="created_asc">Created (Oldest first)</option>
                                <option value="created_desc">Created (Newest first)</option>
                                <option value="users_desc">Most Users</option>
                                <option value="users_asc">Fewest Users</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Section -->
            <div class="flex flex-col">
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
                                        Description
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Users
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Permissions
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Created At
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody id="rolesTableBody" class="bg-white divide-y divide-gray-200">
                                @foreach($roles as $role)
                                    <tr class="hover:bg-gray-50 role-row"
                                        data-role-id="{{ $role->id }}"
                                        data-role-name="{{ strtolower($role->name) }}"
                                        data-role-users="{{ $role->users_count }}"
                                        data-role-created="{{ $role->created_at->timestamp }}">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                                    <span
                                                        class="text-indigo-700 font-medium">{{ strtoupper(substr($role->name, 0, 2)) }}</span>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ ucfirst($role->name) }}
                                                    </div>
                                                    @if($role->name === 'admin')
                                                        <div class="text-xs text-indigo-500">
                                                            System Role
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900 max-w-md">
                                                {{ $role->description ?: 'No description provided' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $role->users_count }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $role->permissions->count() > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                {{ $role->permissions->count() }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $role->created_at->format('Y-m-d') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end space-x-2">
                                                <button type="button"
                                                        onclick="openEditRoleModal({{ $role->id }})"
                                                        class="text-indigo-600 hover:text-indigo-900">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                                    </svg>
                                                </button>

                                                <button type="button"
                                                        onclick="openDeleteConfirmModal({{ $role->id }}, '{{ $role->name }}')"
                                                        class="text-red-600 hover:text-red-900 {{ $role->users_count > 0 ? 'cursor-not-allowed opacity-50' : '' }}"
                                                    {{ $role->users_count > 0 ? 'disabled' : '' }}>
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                         viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>

                                                <a href="{{ route('admin.roles.show', $role->id) }}"
                                                   class="text-gray-600 hover:text-gray-900">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                         viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                @if(count($roles) === 0)
                    <div class="bg-white px-4 py-8 text-center border-b border-gray-200">
                        <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-900">No roles found</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating a new role.</p>
                        <div class="mt-6">
                            <button type="button" onclick="openCreateRoleModal()"
                                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                     fill="currentColor">
                                    <path fill-rule="evenodd"
                                          d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                          clip-rule="evenodd"/>
                                </svg>
                                New Role
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Create Role Modal -->
    <x-modal id="createRoleModal" title="Create New Role" iconType="create">
        <form action="{{ route('admin.roles.store') }}" method="POST">
            @csrf
            <div class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Role Name</label>
                    <div class="mt-1">
                        <input type="text" name="name" id="name"
                               class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                               placeholder="Enter role name" required>
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <div class="mt-1">
                    <textarea name="description" id="description" rows="3"
                              class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                              placeholder="Enter role description"></textarea>
                    </div>
                </div>

                <div>
                    <label for="permissions" class="block text-sm font-medium text-gray-700">Permissions</label>
                    <div class="mt-1 relative">
                        <select id="permissions" name="permissions[]" multiple
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md h-32">
                            @foreach(\App\Models\Permission::all() as $permission)
                                <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                            @endforeach
                        </select>
                        <p class="mt-2 text-sm text-gray-500">Hold Ctrl (or Cmd) to select multiple permissions</p>
                    </div>
                </div>
            </div>

            <div class="pt-5 mt-6 border-t border-gray-200">
                <div class="flex justify-end">
                    <button type="button"
                            class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            onclick="closeCreateRoleModal()">
                        Cancel
                    </button>
                    <button type="submit"
                            class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Create Role
                    </button>
                </div>
            </div>
        </form>
    </x-modal>

    <!-- Edit Modal -->
    <x-modal id="editRoleModal" title="Edit Role" iconType="edit">
        <form id="updateRoleForm" action="" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <input type="hidden" name="role_id" id="edit_role_id">

                <div>
                    <label for="edit_name" class="block text-sm font-medium text-gray-700">Role Name</label>
                    <div class="mt-1">
                        <input type="text" name="name" id="edit_name"
                               class="shadow-sm focus:ring-yellow-500 focus:border-yellow-500 block w-full sm:text-sm border-gray-300 rounded-md"
                               placeholder="Enter role name" required>
                    </div>
                </div>

                <div>
                    <label for="edit_description" class="block text-sm font-medium text-gray-700">Description</label>
                    <div class="mt-1">
                    <textarea name="description" id="edit_description" rows="3"
                              class="shadow-sm focus:ring-yellow-500 focus:border-yellow-500 block w-full sm:text-sm border-gray-300 rounded-md"
                              placeholder="Enter role description"></textarea>
                    </div>
                </div>

                <div>
                    <label for="edit_permissions" class="block text-sm font-medium text-gray-700">Permissions</label>
                    <div class="mt-1 relative">
                        <select id="edit_permissions" name="permissions[]" multiple
                                class="shadow-sm focus:ring-yellow-500 focus:border-yellow-500 block w-full sm:text-sm border-gray-300 rounded-md h-32">
                            @foreach(\App\Models\Permission::all() as $permission)
                                <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                            @endforeach
                        </select>
                        <p class="mt-2 text-sm text-gray-500">Hold Ctrl (or Cmd) to select multiple permissions</p>
                    </div>
                </div>

                <div id="is_system_role_notice" class="hidden mt-4 p-4 bg-yellow-50 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                 fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">System role</h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <p>This is a core system role. Some settings may be restricted.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-5 mt-6 border-t border-gray-200">
                <div class="flex justify-end">
                    <button type="button"
                            class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500"
                            onclick="closeEditRoleModal()">
                        Cancel
                    </button>
                    <button type="submit"
                            class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                        Update Role
                    </button>
                </div>
            </div>
        </form>
    </x-modal>

    <!-- Delete Confirmation Modal -->
    <x-modal id="deleteConfirmModal" title="Delete Role" iconType="delete">
        <div class="space-y-4">
            <p class="text-sm text-gray-500" id="deleteConfirmText">
                Are you sure you want to delete this role? This action cannot be undone.
            </p>

            <div class="pt-5 mt-6 border-t border-gray-200">
                <div class="flex justify-end space-x-3">
                    <button type="button"
                            class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                            onclick="closeDeleteConfirmModal()">
                        Cancel
                    </button>
                    <form id="deleteRoleForm" method="POST" action="" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </x-modal>

    <script>
        const roles = @json($roles);
        // Modal functions
        function openCreateRoleModal() {
            document.getElementById('createRoleModal').classList.remove('hidden');
        }

        function closeCreateRoleModal() {
            document.getElementById('createRoleModal').classList.add('hidden');
        }

        // Open edit role modal
        function openEditRoleModal(roleId) {
            console.log(roleId);
            const role = roles.find(r => r.id === roleId);
            if (!role) return;

            document.getElementById('edit_name').value = role.name;
            document.getElementById('edit_description').value = role.description || '';

            // Clear all selected permissions first
            const permissionSelect = document.getElementById('edit_permissions');
            Array.from(permissionSelect.options).forEach(option => {
                option.selected = false;
            });

            // Select the role's permissions
            if (role.permissions && role.permissions.length > 0) {
                role.permissions.forEach(permission => {
                    const option = permissionSelect.querySelector(`option[value="${permission.id}"]`);
                    if (option) option.selected = true;
                });
            }

            // Show warning if this is a system role
            const systemRoleNotice = document.getElementById('is_system_role_notice');
            if (role.is_system) {
                systemRoleNotice.classList.remove('hidden');
                document.getElementById('edit_name').readOnly = true;
            } else {
                systemRoleNotice.classList.add('hidden');
                document.getElementById('edit_name').readOnly = false;
            }

            // Set the form action URL
            document.getElementById('updateRoleForm').action = `{{ url('/admin/roles') }}/${roleId}`;
            document.getElementById('edit_role_id').value = roleId;

            document.getElementById('editRoleModal').classList.remove('hidden');
        }
        // close edit role modal
        function closeEditRoleModal() {
            document.getElementById('editRoleModal').classList.add('hidden');
        }


        function openDeleteConfirmModal(roleId, roleName) {
            const hasUsers = document.querySelector(`tr[data-role-id="${roleId}"] td:nth-child(3) div`).textContent.trim() !== '0';

            if (hasUsers) {
                alert('Cannot delete a role that has assigned users.');
                return;
            }

            document.getElementById('deleteConfirmText').innerText = `Are you sure you want to delete the role "${roleName}"? This action cannot be undone.`;
            document.getElementById('deleteRoleForm').action = `{{ url('admin/roles') }}/${roleId}`;
            document.getElementById('deleteConfirmModal').classList.remove('hidden');
        }

        function closeDeleteConfirmModal() {
            document.getElementById('deleteConfirmModal').classList.add('hidden');
        }

        // Close modals when clicking outside
        window.addEventListener('click', function (event) {
            const createModal = document.getElementById('createRoleModal');
            const deleteModal = document.getElementById('deleteConfirmModal');

            if (event.target === createModal) {
                closeCreateRoleModal();
            }

            if (event.target === deleteModal) {
                closeDeleteConfirmModal();
            }
        });

        // Search functionality
        document.getElementById('roleSearch').addEventListener('input', function () {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('.role-row');

            rows.forEach(row => {
                const roleName = row.getAttribute('data-role-name');
                const roleDescription = row.querySelector('td:nth-child(2) div').textContent.toLowerCase();

                if (roleName.includes(searchTerm) || roleDescription.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Sorting functionality
        document.getElementById('sortRoles').addEventListener('change', function () {
            const sortOption = this.value;
            const tbody = document.getElementById('rolesTableBody');
            const rows = Array.from(tbody.querySelectorAll('tr.role-row'));

            rows.sort((a, b) => {
                if (sortOption === 'name_asc') {
                    return a.getAttribute('data-role-name').localeCompare(b.getAttribute('data-role-name'));
                } else if (sortOption === 'name_desc') {
                    return b.getAttribute('data-role-name').localeCompare(a.getAttribute('data-role-name'));
                } else if (sortOption === 'created_asc') {
                    return a.getAttribute('data-role-created') - b.getAttribute('data-role-created');
                } else if (sortOption === 'created_desc') {
                    return b.getAttribute('data-role-created') - a.getAttribute('data-role-created');
                } else if (sortOption === 'users_desc') {
                    return b.getAttribute('data-role-users') - a.getAttribute('data-role-users');
                } else if (sortOption === 'users_asc') {
                    return a.getAttribute('data-role-users') - b.getAttribute('data-role-users');
                }
                return 0;
            });

            // Remove existing rows
            rows.forEach(row => row.remove());

            // Append sorted rows
            rows.forEach(row => tbody.appendChild(row));
        });

        // Auto-hide flash messages
        setTimeout(function () {
            const successAlert = document.getElementById('successAlert');
            const errorAlert = document.getElementById('errorAlert');

            if (successAlert) {
                successAlert.remove();
            }

            if (errorAlert) {
                errorAlert.remove();
            }
        }, 5000);
    </script>
@endsection
