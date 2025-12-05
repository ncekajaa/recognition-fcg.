<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Face Recognition Absensi')</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- TensorFlow.js -->
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>

    <!-- Face-api.js -->
    <script src="https://cdn.jsdelivr.net/npm/@vladmandic/face-api/dist/face-api.min.js"></script>

    <!-- Light Theme Styles -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #ffffff, #f3f5ff, #eef6ff);
            color: #1F2937;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            position: relative;
        }

        /* Soft Light Glow Bubbles */
        .bubble {
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(
                circle at 30% 30%, 
                rgba(124, 58, 237, 0.18), 
                rgba(59, 130, 246, 0.10)
            );
            filter: blur(80px);
            animation: float 22s infinite ease-in-out;
            z-index: -1;
        }

        .bubble1 { width: 300px; height: 300px; top: 5%; left: 8%; }
        .bubble2 { width: 450px; height: 450px; bottom: 10%; right: 10%; animation-delay: 4s; }
        .bubble3 { width: 250px; height: 250px; top: 60%; left: 55%; animation-delay: 10s; }

        @keyframes float {
            0%, 100% { transform: translate(0, 0); }
            33%      { transform: translate(60px, -40px); }
            66%      { transform: translate(-40px, 50px); }
        }

        /* Navbar */
        nav {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(124, 58, 237, 0.15);
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .nav-container {
            max-width: 1300px;
            margin: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.6rem;
            font-weight: 700;
            background: linear-gradient(120deg, #7C3AED, #3B82F6);
            -webkit-background-clip: text;
            color: transparent;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 2rem;
        }

        .nav-links a {
            color: #4B5563;
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 0.8rem;
            border-radius: 6px;
            transition: 0.25s;
        }

        .nav-links a:hover {
            color: #7C3AED;
            background: rgba(124, 58, 237, 0.15);
            box-shadow: 0 0 10px rgba(124, 58, 237, 0.25);
        }

        /* Main */
        main {
            flex: 1;
            max-width: 1400px;
            margin: 2rem auto;
            padding: 1rem 1.5rem;
            position: relative;
        }

        /* Footer */
        footer {
            background: rgba(255, 255, 255, 0.9);
            border-top: 1px solid rgba(124, 58, 237, 0.2);
            padding: 1.2rem;
            text-align: center;
            color: #6B7280;
            font-size: 0.9rem;
        }

        footer a {
            color: #7C3AED;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        /* Mobile */
        @media (max-width: 768px) {
            .nav-container {
                flex-direction: column;
                gap: 1rem;
            }
            .nav-links {
                gap: 1rem;
            }
        }
    </style>

    @yield('styles')
</head>

<body>

    <!-- Floating Lights -->
    <div class="bubble bubble1"></div>
    <div class="bubble bubble2"></div>
    <div class="bubble bubble3"></div>

    <!-- NAV -->
    <nav>
        <div class="nav-container">
            <a href="{{ route('absen.index') }}" class="logo">
                <i class="fa-solid fa-bolt-lightning"></i> FaceAbsen
            </a>

            <ul class="nav-links">
                <li><a href="{{ route('absen.index') }}"><i class="fa-solid fa-camera"></i> Absensi</a></li>
                <li><a href="{{ route('dashboard') }}"><i class="fa-solid fa-chart-line"></i> Dashboard</a></li>
            </ul>
        </div>
    </nav>

    <!-- MAIN -->
    <main>
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer>
        <p>© 2025 FaceAbsen • Designed in Light Mode ✨</p>
    </footer>

    @yield('scripts')
</body>
</html>
