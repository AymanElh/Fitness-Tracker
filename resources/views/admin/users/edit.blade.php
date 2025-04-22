<!-- resources/views/admin/users/edit.blade.php -->
@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
    <div class="container px-6 mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Edit User</h2>
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 text-sm bg-gray-200 hover:bg-gray-300 rounded-md">
                Back to Users
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-sm overflow-hidden p-6">
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                    @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                    @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" required
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                        {{ auth()->id() === $user->id ? 'disabled' : '' }}>
                        <option value="active" {{ old('status', $user->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="banned" {{ old('status', $user->status) === 'banned' ? 'selected' : '' }}>Banned</option>
                    </select>
                    @if(auth()->id() === $user->id)
                        <input type="hidden" name="status" value="{{ $user->status }}">
                        <p class="mt-1 text-sm text-yellow-600">You cannot change your own status.</p>
                    @endif
                    @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Add other fields as needed -->

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white hover:bg-blue-700 rounded-md">
                        Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
