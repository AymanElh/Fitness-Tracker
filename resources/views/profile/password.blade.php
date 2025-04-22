<!-- resources/views/profile/password.blade.php -->
@extends('layouts.app')

@section('title', 'Change Password')

@section('content')
    <section class="pt-32 pb-16 bg-slate-900">
        <div class="container mx-auto px-4">
            <div class="max-w-md mx-auto">
                <div class="mb-8 flex items-center justify-between">
                    <h1 class="text-3xl font-bold text-white">
                        Change <span class="gradient-text">Password</span>
                    </h1>
                    <a href="{{ route('profile.show') }}" class="bg-white/10 hover:bg-white/20 py-2 px-4 rounded-lg text-white inline-flex items-center transition">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Profile
                    </a>
                </div>

                <!-- Success message -->
                @if (session('success'))
                    <div class="bg-green-500/20 border border-green-500/50 text-green-400 px-4 py-3 rounded-lg mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('profile.password.update') }}" method="POST" class="bg-slate-800/50 rounded-xl p-6 shadow-lg">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <div>
                            <label for="current_password" class="block text-gray-300 mb-2">Current Password <span class="text-red-500">*</span></label>
                            <input type="password" name="current_password" id="current_password" required
                                   class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('current_password')
                            <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-gray-300 mb-2">New Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password" id="password" required
                                   class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('password')
                            <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-gray-300 mb-2">Confirm New Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                   class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="mt-8 flex justify-center">
                        <button type="submit" class="btn-primary py-3 px-8 rounded-lg text-white inline-flex items-center transition text-lg">
                            <i class="fas fa-lock mr-2"></i> Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
