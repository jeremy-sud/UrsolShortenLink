<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistemas Ursol - URL Shortener</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #0f172a;
            color: #e2e8f0;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ursol: {
                            50: '#f0f9ff',
                            500: '#0ea5e9',
                            900: '#0c4a6e',
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="min-h-screen flex flex-col overflow-hidden selection:bg-cyan-500/30">

    <!-- Navbar -->
    <nav class="w-full p-6 flex items-center justify-between max-w-7xl mx-auto z-10">
        <a href="https://ursol.com/" target="_blank" rel="noopener noreferrer"
            class="flex items-center gap-3 hover:opacity-80 transition-opacity">
            <img src="assets/iconoUrsol.webp" alt="Sistemas Ursol Logo" class="h-10 w-auto object-contain">
            <span class="text-xl font-semibold tracking-tight text-white">Sistemas Ursol</span>
        </a>
    </nav>

    <!-- Main Content -->
    <main class="flex-1 flex items-center justify-center p-6 w-full max-w-7xl mx-auto">
        <div class="flex flex-col lg:flex-row items-center justify-between w-full gap-12 lg:gap-24">

            <!-- Left Side: Branding & Text -->
            <div class="flex-1 text-center lg:text-left space-y-6 max-w-2xl">
                <h1 class="text-5xl lg:text-7xl font-bold text-white tracking-tight leading-tight">
                    Shorten links, <br />
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-600">
                        expand reach.
                    </span>
                </h1>
                <p class="text-slate-400 text-xl max-w-lg mx-auto lg:mx-0 leading-relaxed">
                    The professional URL shortener for modern businesses. Fast, secure, and reliable.
                </p>

                <!-- Ad Section -->
                <div class="mt-8 p-4 border border-slate-700/50 rounded-lg bg-slate-800/30 max-w-md mx-auto lg:mx-0">
                    <p class="text-xs text-slate-500 uppercase tracking-widest mb-1">Advertisement</p>
                    <p class="text-sm text-slate-400 italic">
                        Contactanos para publicitarte en este espacio
                    </p>
                </div>
            </div>

            <!-- Right Side: Action Card -->
            <div class="flex-1 w-full max-w-xl">
                <div class="glass-panel p-8 lg:p-10 shadow-2xl shadow-cyan-900/20 rounded-3xl">
                    <form id="shortenForm" class="space-y-4">
                        <div>
                            <label htmlFor="url" class="block text-sm font-medium text-slate-300 mb-2 ml-1">
                                Paste your long URL
                            </label>
                            <div class="relative">
                                <input type="url" id="urlInput" required
                                    placeholder="https://example.com/very-long-url..."
                                    class="w-full px-6 py-4 bg-slate-900/50 border border-slate-700 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-transparent outline-none transition-all text-white placeholder-slate-500 text-lg" />
                            </div>
                        </div>

                        <button type="submit" id="submitBtn"
                            class="w-full py-4 px-6 bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 text-white font-bold text-lg rounded-xl transition-all transform hover:scale-[1.02] active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed shadow-lg shadow-cyan-500/20">
                            Shorten URL
                        </button>
                    </form>

                    <div id="errorMsg"
                        class="hidden mt-4 p-3 bg-red-500/10 border border-red-500/20 rounded-lg text-red-400 text-sm text-center">
                    </div>

                    <div id="resultArea"
                        class="hidden mt-6 p-4 bg-slate-900/50 border border-slate-700 rounded-xl animate-fade-in">
                        <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold mb-2">Your Short Link
                        </p>
                        <div class="flex items-center gap-3">
                            <input type="text" id="shortUrlInput" readonly
                                class="flex-1 bg-transparent border-none p-0 text-cyan-400 font-mono text-lg focus:ring-0" />
                            <button id="copyBtn" onclick="copyToClipboard()"
                                class="px-4 py-2 rounded-lg font-medium text-sm transition-all bg-slate-700 hover:bg-slate-600 text-white">
                                Copy
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full p-6 border-t border-slate-800/50 z-10 bg-[#0f172a]/80 backdrop-blur-sm">
        <div
            class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4 text-sm text-slate-500">
            <div>
                &copy;
                <script>document.write(new Date().getFullYear())</script> <a href="https://ursol.com/" target="_blank"
                    rel="noopener noreferrer" class="hover:text-cyan-400 transition-colors">Sistemas Ursol S.A.</a> All
                rights reserved.
            </div>

            <div class="flex items-center gap-4">
                <span>Developed by</span>
                <a href="https://sites.google.com/view/repdevursol/home" target="_blank" rel="noopener noreferrer"
                    class="group flex items-center gap-2 hover:opacity-100 opacity-70 transition-all">
                    <img src="assets/repdev-logo.png" alt="RepDev Logo"
                        class="h-6 w-auto object-contain grayscale group-hover:grayscale-0 transition-all">
                    <span class="group-hover:text-white transition-colors">RepDev</span>
                </a>
            </div>
        </div>
    </footer>

    <script>
        const form = document.getElementById('shortenForm');
        const urlInput = document.getElementById('urlInput');
        const submitBtn = document.getElementById('submitBtn');
        const errorMsg = document.getElementById('errorMsg');
        const resultArea = document.getElementById('resultArea');
        const shortUrlInput = document.getElementById('shortUrlInput');
        const copyBtn = document.getElementById('copyBtn');

        // Check for error parameter in URL (e.g. from redirect.php)
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('error') === 'not_found') {
            errorMsg.textContent = 'The requested short URL was not found.';
            errorMsg.classList.remove('hidden');
            // Remove param from URL without refresh
            window.history.replaceState({}, document.title, "/");
        }

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            // Reset UI
            submitBtn.disabled = true;
            submitBtn.textContent = 'Shortening...';
            errorMsg.classList.add('hidden');
            resultArea.classList.add('hidden');

            const originalUrl = urlInput.value;

            try {
                const response = await fetch('api/shorten.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ originalUrl }),
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.error || 'Failed to shorten URL');
                }

                shortUrlInput.value = data.shortUrl;
                resultArea.classList.remove('hidden');
            } catch (err) {
                errorMsg.textContent = err.message || 'Something went wrong. Please try again.';
                errorMsg.classList.remove('hidden');
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Shorten URL';
            }
        });

        function copyToClipboard() {
            const shortUrl = shortUrlInput.value;
            navigator.clipboard.writeText(shortUrl);

            copyBtn.textContent = 'Copied!';
            copyBtn.classList.remove('bg-slate-700', 'hover:bg-slate-600', 'text-white');
            copyBtn.classList.add('bg-green-500/20', 'text-green-400');

            setTimeout(() => {
                copyBtn.textContent = 'Copy';
                copyBtn.classList.add('bg-slate-700', 'hover:bg-slate-600', 'text-white');
                copyBtn.classList.remove('bg-green-500/20', 'text-green-400');
            }, 2000);
        }
    </script>
</body>

</html>