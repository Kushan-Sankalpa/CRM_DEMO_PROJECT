<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3>Welcome, {{ Auth::user()->name }}!</h3>
                    <p>Email: {{ Auth::user()->email }}</p>
                    <a href="{{ route('profile.edit') }}" class="text-blue-500">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>