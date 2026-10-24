<x-home-layout title="Masuk">
    <div class="max-w-md mx-auto">
        <div class="bg-white border border-brand-sky rounded-xl shadow p-8">
            <h1 class="text-2xl font-extrabold mb-1">Masuk Admin</h1>
            <p class="text-sm text-gray-500 mb-6">Masuk untuk mengelola produk dan pesanan.</p>

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full border border-brand-sky rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-brand-blue/40">
                    @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Password</label>
                    <input type="password" name="password" required
                           class="w-full border border-brand-sky rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-brand-blue/40">
                    @error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="remember"> Ingat saya</label>
                <button class="w-full py-2.5 rounded-lg bg-brand-blue text-white font-medium hover:bg-brand-navy">Masuk</button>
            </form>
        </div>
    </div>
</x-home-layout>
