<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} | Josepa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">
    @include('layouts.navigationhome')

    <main class="min-h-screen">
        {{ $slot }}
    </main>

    <footer class="bg-gray-900 text-gray-300 mt-16">
        <div class="max-w-6xl mx-auto px-4 py-8 flex flex-col sm:flex-row justify-between gap-4 text-sm">
            <div>
                <p class="text-white font-semibold text-lg">Josepa</p>
                <p>Toko sepatu pilihan untuk kuliah, kerja, dan jalan-jalan.</p>
            </div>
            <p class="sm:text-right">&copy; {{ date('Y') }} Josepa. Dibuat untuk Evaluasi 1 Web Prototyping A.</p>
        </div>
    </footer>
</body>
</html>
