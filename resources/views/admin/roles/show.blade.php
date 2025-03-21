@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Role Details: {{ $role->display_name ?? $role->name }}</h1>
            <div>
                <a href="{{ route('roles.edit', $role) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 mr-2">
                    Edit Role
                </a>
                <a href="{{ route('roles.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                    Back to Roles
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Name</dt>
                    <dd class="mt-1 text-lg text-gray-900">{{ $role->name }}</dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-gray-500">Display Name</dt>
                    <dd class="mt-1 text-lg text-gray-900">{{ $role->display_name ?? '-' }}</dd>
                </div>

                <div class="md:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">Description</dt>
                    <dd class="mt-1 text-lg text-gray-900">{{ $role->description ?? '-' }}</dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-gray-500">Created At</dt>
                    <dd class="mt-1 text-lg text-gray-900">{{ $role->created_at->format('Y-m-d H:i') }}</dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                    <dd class="mt-1 text-lg text-gray-900">{{ $role->updated_at->format('Y-m-d H:i') }}</dd>
                </div>
            </dl>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Permissions</h2>

            @if($role->permissions->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($role->permissions as $permission)
                        <div class="bg-gray-50 p-3 rounded-md">
                            <h3 class="font-medium text-gray-900">{{ $permission->display_name ?? $permission->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $permission->description ?? '' }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">No permissions assigned to this role.</p>
            @endif
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Users with this Role</h2>

            @if($role->users->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($role->users as $user)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $user->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.users.roles.edit', $user) }}" class="text-indigo-600 hover:text-indigo-900">
                                        Manage Roles
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500">No users have been assigned this role.</p>
            @endif
        </div>
    </div>
@endsection
