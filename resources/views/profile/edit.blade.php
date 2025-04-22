<!-- resources/views/profile/edit.blade.php -->
@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <section class="pt-32 pb-16 bg-slate-900">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <div class="mb-8 flex items-center justify-between">
                    <h1 class="text-3xl font-bold text-white">
                        Edit <span class="gradient-text">Profile</span>
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

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="bg-slate-800/50 rounded-xl p-6 shadow-lg">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Profile Photo -->
                        <div class="md:col-span-2 flex flex-col items-center">
                            <div class="w-32 h-32 mb-4 relative">
                                <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="w-full h-full rounded-full object-cover">

                                @if($user->profile_photo_path)
                                    <form action="{{ route('profile.photo.delete') }}" method="POST" class="absolute -top-2 -right-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure you want to remove your profile photo?')" class="bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center shadow hover:bg-red-600">
                                            <i class="fas fa-times text-xs"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>

                            <div class="mb-6">
                                <label for="profile_photo" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg cursor-pointer inline-block">
                                    <i class="fas fa-camera mr-2"></i> {{ $user->profile_photo_path ? 'Change Photo' : 'Upload Photo' }}
                                </label>
                                <input type="file" name="profile_photo" id="profile_photo" class="hidden" accept="image/*">
                                @error('profile_photo')
                                <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Basic Information -->
                        <div>
                            <label for="name" class="block text-gray-300 mb-2">Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                                   class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('name')
                            <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-gray-300 mb-2">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                                   class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('email')
                            <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Physical Stats -->
                        <div>
                            <label for="weight" class="block text-gray-300 mb-2">Weight (kg)</label>
                            <input type="number" name="weight" id="weight" value="{{ old('weight', $user->weight) }}" step="0.1" min="20" max="500"
                                   class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('weight')
                            <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="height" class="block text-gray-300 mb-2">Height (cm)</label>
                            <input type="number" name="height" id="height" value="{{ old('height', $user->height) }}" step="0.1" min="100" max="250"
                                   class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('height')
                            <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="date_of_birth" class="block text-gray-300 mb-2">Date of Birth</label>
                            <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth?->format('Y-m-d')) }}"
                                   class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('date_of_birth')
                            <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="gender" class="block text-gray-300 mb-2">Gender</label>
                            <select name="gender" id="gender"
                                    class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Prefer not to say</option>
                                <option value="male" {{ old('gender', $user->gender) === 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender', $user->gender) === 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender', $user->gender) === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')
                            <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Bio -->
                        <div class="md:col-span-2">
                            <label for="bio" class="block text-gray-300 mb-2">Bio</label>
                            <textarea name="bio" id="bio" rows="4"
                                      class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('bio', $user->bio) }}</textarea>
                            @error('bio')
                            <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-8 flex justify-center">
                        <button type="submit" class="btn-primary py-3 px-8 rounded-lg text-white inline-flex items-center transition text-lg">
                            <i class="fas fa-save mr-2"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script>
        // Show preview of selected profile photo
        document.getElementById('profile_photo').addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();

                reader.onload = function(event) {
                    const preview = document.querySelector('img');
                    preview.src = event.target.result;
                }

                reader.readAsDataURL(e.target.files[0]);
            }
        });
    </script>
@endsection
