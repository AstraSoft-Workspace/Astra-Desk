<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Astra Desk — Connect Smarter</title>
    <script src="https://cdn.tailwindcss.com"></script>

   <style>
    body {
        background: #0a0f1a;
        background: -webkit-linear-gradient(90deg, #0a0f1a 0%, #1a2233 50%, #101624 100%);
        background: -moz-linear-gradient(90deg, #0a0f1a 0%, #1a2233 50%, #101624 100%);
        background: linear-gradient(90deg, #0a0f1a 0%, #1a2233 50%, #101624 100%);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#0a0f1a", endColorstr="#101624", GradientType=1);
    }
   </style>
</head>


<body class="bg-gray-900 text-white min-h-screen flex flex-col">

    <!-- Navbar -->
    <header class="p-4 flex justify-between items-center border-b border-gray-700 bg-gray-900 fixed top-0 left-0 right-0 z-50  shadow-lg ">
        <div class="text-xl font-bold tracking-wide flex items-center gap-2">
            <span class="inline-block w-3 h-3 bg-blue-500 rounded-full"></span>
            Astra Desk
        </div>
        <nav class="hidden md:flex items-center gap-6 text-sm">
            <a href="index.php" class="hover:text-blue-400 transition">Home</a>
            <a href="features.html" class="hover:text-blue-400 transition">Features</a>
            <a href="pricing.html" class="hover:text-blue-400 transition">Pricing</a>
            <a href="about.html" class="hover:text-blue-400 transition">About</a>
            <a href="login.html" class="bg-blue-600 hover:bg-blue-700 px-4 py-1.5 rounded text-white font-semibold transition">Login</a>
            <a href="register.html" class="border border-gray-500 hover:border-blue-400 px-4 py-1.5 rounded text-gray-300 hover:text-white transition">Register</a>
        </nav>
        <!-- Hamburger Button (Mobile) -->
        <button id="menu-toggle" class="md:hidden flex items-center px-3 py-2 border rounded text-gray-400 border-gray-600 hover:text-white hover:border-blue-400 transition" aria-label="Open menu">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden fixed inset-0 bg-gray-900 bg-opacity-95 z-50 flex flex-col items-center justify-center space-y-6 text-lg font-semibold transition-all duration-300 opacity-0 pointer-events-none">
            <button id="menu-close" class="absolute top-6 right-6 text-gray-400 hover:text-white transition" aria-label="Close menu">
            <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            </button>
            <a href="index.php" class="hover:text-blue-400 transition" onclick="closeMenu()">Home</a>
            <a href="features.html" class="hover:text-blue-400 transition" onclick="closeMenu()">Features</a>
            <a href="pricing.html" class="hover:text-blue-400 transition" onclick="closeMenu()">Pricing</a>
            <a href="about.html" class="hover:text-blue-400 transition" onclick="closeMenu()">About</a>
            <a href="register.html" class="border border-gray-500 hover:border-blue-400 px-8 py-3 rounded text-gray-300 hover:text-white transition" onclick="closeMenu()">Register</a>
            <a href="login.html" class="bg-blue-600 hover:bg-blue-700 px-8 py-3 rounded text-white font-semibold transition" onclick="closeMenu()">Login</a>

        </div>
        <script>
            const menuToggle = document.getElementById('menu-toggle');
            const mobileMenu = document.getElementById('mobile-menu');
            const menuClose = document.getElementById('menu-close');

            function openMenu() {
            mobileMenu.classList.remove('opacity-0', 'pointer-events-none');
            mobileMenu.classList.add('opacity-100', 'pointer-events-auto');
            }
            function closeMenu() {
            mobileMenu.classList.add('opacity-0', 'pointer-events-none');
            mobileMenu.classList.remove('opacity-100', 'pointer-events-auto');
            }

            menuToggle.addEventListener('click', openMenu);
            menuClose.addEventListener('click', closeMenu);

            // Optional: Close menu when clicking outside or pressing ESC
            document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeMenu();
            });
        </script>
    </header>

    <!-- Hero -->
    <main class="flex-1 flex flex-col items-center justify-center text-center px-4 py-16 space-y-16 " style="margin-top: 80px;">

        <section class="max-w-2xl mx-auto space-y-8 " style="height: 50vh;">
            <h1 class="text-3xl sm:text-5xl font-extrabold mb-4 leading-tight">
                Minimalist Chat, <span class="text-blue-500">Maximal Focus</span>
            </h1>
            <p class="text-gray-400 max-w-xl mx-auto mb-6 text-lg">
                Astra Desk helps you stay connected through fast, secure, and clutter-free conversations — whether you're chatting 1-on-1 or in groups.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center mt-4">
                <a href="register.html" class="border border-gray-500 hover:border-blue-400 px-8 py-3 rounded text-gray-300 hover:text-white text-base transition">Create Account</a>
                <a href="login.html" class="bg-blue-600 hover:bg-blue-700 px-8 py-3 rounded text-white font-semibold text-base transition">Login</a>

            </div>
        </section>

        <!-- Features Section -->
        <section class="w-full py-12 px-4 sm:px-6 lg:px-8 bg-gray-900 text-white border-t border-gray-800 rounded-lg shadow-lg">
            <h2 class="text-2xl sm:text-3xl font-bold text-center mb-12">Why Astra Desk?</h2>
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3 max-w-6xl mx-auto">
                <!-- Feature Card 1 -->
                <div class="bg-gray-800 border border-gray-700 rounded-xl p-8 flex flex-col items-center text-center hover:shadow-2xl transition-all duration-300 space-y-2">
                    <span class="text-blue-400 text-3xl mb-2">💬</span>
                    <h3 class="text-lg font-semibold">Real-Time Messaging</h3>
                    <p class="text-sm text-gray-400">
                        Enjoy fast and smooth communication with instant message delivery and typing indicators.
                    </p>
                </div>
                <!-- Feature Card 2 -->
                <div class="bg-gray-800 border border-gray-700 rounded-xl p-8 flex flex-col items-center text-center hover:shadow-2xl transition-all duration-300 space-y-2">
                    <span class="text-green-400 text-3xl mb-2">👥</span>
                    <h3 class="text-lg font-semibold">Group & Private Chats</h3>
                    <p class="text-sm text-gray-400">
                        Start private conversations or create groups for teams, projects, or social interactions.
                    </p>
                </div>
                <!-- Feature Card 3 -->
                <div class="bg-gray-800 border border-gray-700 rounded-xl p-8 flex flex-col items-center text-center hover:shadow-2xl transition-all duration-300 space-y-2">
                    <span class="text-yellow-400 text-3xl mb-2">🟢</span>
                    <h3 class="text-lg font-semibold">User Presence</h3>
                    <p class="text-sm text-gray-400">
                        Instantly see who's online and available to chat. Presence updates in real-time.
                    </p>
                </div>
                <!-- Feature Card 4 -->
                <div class="bg-gray-800 border border-gray-700 rounded-xl p-8 flex flex-col items-center text-center hover:shadow-2xl transition-all duration-300 space-y-2">
                    <span class="text-purple-400 text-3xl mb-2">🔒</span>
                    <h3 class="text-lg font-semibold">Secure & Private</h3>
                    <p class="text-sm text-gray-400">
                        All conversations are protected with secure authentication and privacy-first architecture.
                    </p>
                </div>
                <!-- Feature Card 5 -->
                <div class="bg-gray-800 border border-gray-700 rounded-xl p-8 flex flex-col items-center text-center hover:shadow-2xl transition-all duration-300 space-y-2">
                    <span class="text-pink-400 text-3xl mb-2">📱</span>
                    <h3 class="text-lg font-semibold">Mobile-Responsive</h3>
                    <p class="text-sm text-gray-400">
                        Works beautifully across devices — from phones and tablets to desktops.
                    </p>
                </div>
                <!-- Feature Card 6 -->
                <div class="bg-gray-800 border border-gray-700 rounded-xl p-8 flex flex-col items-center text-center hover:shadow-2xl transition-all duration-300 space-y-2">
                    <span class="text-indigo-400 text-3xl mb-2">✨</span>
                    <h3 class="text-lg font-semibold">Simple & Elegant UI</h3>
                    <p class="text-sm text-gray-400">
                        A minimalist design that helps you focus on the conversation, not the clutter.
                    </p>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="text-center text-gray-500 text-xs py-6 border-t border-gray-800 mt-8">
        &copy; <?= date('Y') ?> Astra Softwares. All rights reserved.
    </footer>

</body>
</html>
