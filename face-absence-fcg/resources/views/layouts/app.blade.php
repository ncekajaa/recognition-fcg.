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
       /* Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body */
body {
    font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f8faff;
    color: #1e293b;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

/* Light Glow Background */
.bg-glow {
    position: fixed;
    inset: 0;
    pointer-events: none;
    z-index: -1;
}

.glow {
    position: absolute;
    border-radius: 50%;
    background: radial-gradient(circle,
        rgba(99, 102, 241, 0.18),
        rgba(139, 92, 246, 0.12)
    );
    filter: blur(90px);
}

.glow1 { width: 350px; height: 350px; top: -10%; left: -5%; }
.glow2 { width: 450px; height: 450px; bottom: -10%; right: -5%; }
.glow3 { width: 250px; height: 250px; top: 50%; left: 60%; }

/* Navbar */
nav {
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(12px);
    border-bottom: 1px solid rgba(99, 102, 241, 0.12);
    padding: 1rem 2rem;
    position: sticky;
    top: 0;
    z-index: 1000;
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
    background: linear-gradient(120deg, #6366f1, #8b5cf6);
    -webkit-background-clip: text;
    color: transparent;
}

/* Menu */
.nav-links {
    list-style: none;
    display: flex;
    gap: 1.8rem;
}

.nav-links a {
    text-decoration: none;
    color: #475569;
    font-weight: 500;
    padding: 0.5rem 0.8rem;
    border-radius: 8px;
    transition: 0.2s ease-in-out;
}

.nav-links a:hover {
    background: rgba(99, 102, 241, 0.15);
    color: #4f46e5;
    box-shadow: 0 0 10px rgba(99, 102, 241, 0.25);
}

/* Main Content */
main {
    flex: 1;
    max-width: 1300px;
    margin: 2rem auto;
    padding: 1rem 1.5rem;
}

/* Footer */
footer {
    background: #ffffffd9;
    border-top: 1px solid rgba(99, 102, 241, 0.1);
    text-align: center;
    padding: 1rem;
    font-size: 0.9rem;
    color: #64748b;
}

footer a {
    color: #6366f1;
    text-decoration: none;
}

footer a:hover {
    text-decoration: underline;
}

/* Mobile */
@media (max-width: 768px) {
    .nav-container {
        flex-direction: column;
        gap: 0.8rem;
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
