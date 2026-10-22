<x-home-layout title="Masuk">
    <div class="max-w-md mx-auto px-4 py-16">
        <div class="bg-white rounded-2xl shadow p-8">
            <h1 class="text-2xl font-bold text-blue-700 mb-1">Masuk</h1>
            <p class="text-sm text-gray-500 mb-6">Masuk sebagai admin untuk mengelola produk.</p>

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                    @error('email')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Password</label>
                    <input type="password" name="password" required
                           class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                    @error('password')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="remember"> Ingat saya</label>
                <button class="w-full py-2.5 rounded-lg bg-blue-700 text-white font-medium hover:bg-blue-800">Masuk</button>
            </form>
        </div>
    </div>
</x-home-layout>
