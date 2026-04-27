<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'App') — Dexornit</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    {{-- Font Awesome v5 --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --matcha-50:  #f4f9f4;
            --matcha-100: #e3f1e5;
            --matcha-200: #c5e2ca;
            --matcha-300: #9bcba3;
            --matcha-400: #6aac76;
            --matcha-500: #4a9058;
            --matcha-600: #3a7347;
            --matcha-700: #2f5c39;
            --matcha-800: #28492f;
            --matcha-900: #213c27;

            --bg:         #f7faf7;
            --surface:    #ffffff;
            --border:     #dde8de;
            --text:       #2c3e2d;
            --text-muted: #6b7f6c;
            --accent:     var(--matcha-500);
            --accent-hover: var(--matcha-600);

            --radius:     12px;
            --shadow-sm:  0 1px 3px rgba(44,62,45,0.07);
            --shadow:     0 4px 16px rgba(44,62,45,0.10);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        a { color: inherit; text-decoration: none; }
        button { cursor: pointer; font-family: inherit; }

        .container {
            width: 100%;
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* ── Main content area ── */
        .main-content {
            flex: 1;
            padding: 40px 0;
        }

        /* ── Responsive helpers ── */
        @media (max-width: 768px) {
            .main-content {
                padding: 24px 0;
            }
            .container {
                padding: 0 16px;
            }
        }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--matcha-50); }
        ::-webkit-scrollbar-thumb { background: var(--matcha-300); border-radius: 99px; }
    </style>
    @yield('styles')
</head>
<body>

    {{-- Navbar Component --}}
    <x-navbar />

    <main class="main-content">
        <div class="container">
            @yield('content')
        </div>
    </main>

    {{-- Footer Component --}}
    <x-footer />

</body>
</html>
