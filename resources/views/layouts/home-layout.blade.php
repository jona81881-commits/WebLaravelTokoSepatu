<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} | Josepa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: { colors: { brand: { navy: '#283583', blue: '#4476DB', sky: '#9ACDE0', mist: '#D3E8E6' } } } }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
    <style>
        html { scroll-behavior: smooth; }
        body { background: #F6FAFA; margin: 0; font-family: 'Plus Jakarta Sans', sans-serif; color: #283583; }
        [x-cloak] { display: none !important; }
        .wrap { width: 100%; max-width: 1520px; margin: auto; padding: 0 40px; box-sizing: border-box; }
        @media (max-width: 960px) { .wrap { padding: 0 5%; } }
        .ikon { width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; flex-shrink: 0; }
        .card-hover { transition: transform .2s ease, box-shadow .2s ease; }
        .card-hover:hover { transform: translateY(-4px); }
        .fade-in { animation: fadeIn .4s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
        /* pagination bawaan Laravel agar serasi */
        nav[role="navigation"] svg { width: 20px; height: 20px; display: inline; }
    </style>
</head>
<body class="antialiased">
<div class="min-h-screen flex flex-col">
    @include('layouts.navigationhome')

    @isset($filter)
        <div class="bg-brand-mist/55 border-b border-brand-sky/45">
            <div class="wrap py-[18px]">{{ $filter }}</div>
        </div>
    @endisset

    <div class="wrap flex-1">
        <div class="my-8">
            {{ $slot }}
        </div>
    </div>

    <footer class="mt-10 py-7 bg-brand-navy text-brand-mist text-center text-sm">
        <div class="wrap">
            <p>© 2026 Josepa | Jonathan Valerio Simatupang | Versi 1.0</p>
        </div>
    </footer>
</div>
</body>
</html>
