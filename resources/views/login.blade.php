<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <meta content="Provident Fund Association" name="description" />
    <meta content="Provident Fund Association" name="keywords" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Login - Provident Fund Association</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700,0..1&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#135bec",
                        "background-light": "#f6f6f8",
                        "background-dark": "#101622",
                    },
                    fontFamily: {
                        "display": ["Public Sans"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>

    <script>
        (function () {
            const saved       = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (saved === 'dark' || (!saved && prefersDark)) {
                document.documentElement.classList.add('dark');
            }
        })();

        function toggleTheme() {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            updateSidebarToggleLabel(isDark);
        }

        // Keep sidebar toggle icon/label in sync with current mode
        function updateSidebarToggleLabel(isDark) {
            const icon  = document.getElementById('sidebar-theme-icon');
            const label = document.getElementById('sidebar-theme-label');
            if (!icon || !label) return;
            icon.textContent  = isDark ? 'light_mode' : 'dark_mode';
            label.textContent = isDark ? 'Light Mode'  : 'Dark Mode';
        }

        // Sync on initial load
        updateSidebarToggleLabel(document.documentElement.classList.contains('dark'));
    </script>
    <style>
        body {
            font-family: 'Public Sans', sans-serif;
            background-image: url('{{ asset('uccbackground.jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .toggle-thumb {
            transition: transform 0.2s ease;
        }

        html.dark .toggle-thumb {
            transform: translateX(18px);
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen flex flex-col">
    <div class="relative flex min-h-screen w-full flex-col overflow-x-hidden">
        <div class="layout-container flex h-full grow flex-col">

            <!-- Header -->
            <header class="flex items-center justify-between border-b border-slate-200 dark:border-slate-800 px-6 py-4 lg:px-20 bg-white dark:bg-slate-900">
                <div class="flex items-center gap-3">
                    {{-- <div class="size-10 flex items-center justify-center bg-primary rounded-lg">
                        <img
                            alt="Institutional Logo"
                            class="size-8 object-contain"
                            src="{{ asset('ucclogo_horizontal_blue.png') }}"
                        />
                    </div> --}}
                    <img
                        alt="Institutional Logo"
                        {{-- class="size-20 object-contain" --}}
                        style="width:180px; height: auto;"
                        src="{{ asset('ucclogo_horizontal_blue.png') }}"
                    />
                    {{-- <h2 class="text-slate-900 dark:text-white text-xl font-bold leading-tight tracking-tight">
                        Provident Fund Association
                    </h2> --}}
                </div>

                
                
                <div class="hidden md:flex items-center gap-2">
                    {{-- <span class="text-sm text-slate-500 dark:text-slate-400">Secure Portal</span>
                    <span class="material-symbols-outlined text-primary text-xl">verified_user</span> --}}
                    <button
                        onclick="toggleTheme()"
                        aria-label="Toggle dark mode"
                        title="Toggle dark mode"
                        class="
                            size-10 flex items-center justify-center
                            rounded-lg bg-slate-100 dark:bg-slate-800
                            text-slate-600 dark:text-slate-400
                            hover:bg-slate-200 dark:hover:bg-slate-700
                            transition-colors
                        "
                    >
                        <span class="material-symbols-outlined dark:hidden">dark_mode</span>
                        <span class="material-symbols-outlined hidden dark:block">light_mode</span>
                    </button>
                </div>
            </header>

            <!-- Main -->
            <main class="flex-1 flex items-center justify-center p-6 lg:p-12">
                <div class="w-full max-w-[1100px] grid lg:grid-cols-2 bg-white dark:bg-slate-900 rounded-xl shadow-xl overflow-hidden">

                {{-- <div class="w-full max-w-[1100px] grid lg:grid-cols-2 bg-white/95 dark:bg-slate-900/95 backdrop-blur-sm rounded-xl shadow-2xl overflow-hidden border border-white/50 dark:border-slate-800/50"> --}}

                    <!-- Left Panel -->
                    <div class="hidden lg:block relative overflow-hidden bg-primary/10">
                    {{-- <div class="hidden lg:block relative overflow-hidden bg-black/50"> --}}
                        <div class="absolute inset-0 bg-gradient-to-br from-primary/20 to-primary/5"></div>

                        {{-- <div class="absolute inset-0 bg-gradient-to-br from-black/30 to-black/70"></div> --}}

                        <div class="relative h-full flex flex-col justify-center p-12 space-y-8">
                            <div>
                                <h1 class="text-4xl font-bold text-slate-900 dark:text-white mb-4">
                                    Provident Fund Association
                                    {{-- Secure Financial Management --}}
                                </h1>
                                <p class="text-lg text-slate-600 dark:text-slate-300">
                                    Access your provident fund account with enterprise-grade security and a seamless interface designed for your peace of mind.
                                </p>
                            </div>

                            <div class="space-y-6">
                                <div class="flex items-start gap-4">
                                    <div class="mt-1 size-8 rounded-full bg-primary/20 flex items-center justify-center text-primary">
                                        <span class="material-symbols-outlined text-lg">shield</span>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-slate-800 dark:text-slate-200">Encrypted Connection</h4>
                                        <p class="text-sm text-slate-500 dark:text-slate-400">
                                            Your data is protected with 256-bit SSL encryption at all times.
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-4">
                                    <div class="mt-1 size-8 rounded-full bg-primary/20 flex items-center justify-center text-primary">
                                        <span class="material-symbols-outlined text-lg">account_balance</span>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-slate-800 dark:text-slate-200">Fund Tracking</h4>
                                        <p class="text-sm text-slate-500 dark:text-slate-400">
                                            Real-time updates on your contributions and association benefits.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-8 border-t border-slate-200 dark:border-slate-800">
                                <p class="text-sm text-slate-400">
                                    © 2024 Provident Fund Association. All rights reserved.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Right Panel (Form) -->
                    <div class="p-8 lg:p-16 flex flex-col justify-center">
                        {{-- echo message from controller --}}
                        @if (session('error'))
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                <strong class="font-bold">Error!</strong>
                                <span class="block sm:inline">{{ session('error') }}</span>
                            </div>
                        @endif
                        <div class="mb-10 text-center lg:text-left">
                            <h2 class="text-3xl font-bold text-slate-900 dark:text-white">Welcome Back</h2>
                            <p class="text-slate-500 dark:text-slate-400 mt-2">
                                Please login to access your account
                            </p>
                        </div>

                        <form class="space-y-6">
                            <!-- Username -->
                            {{-- <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-700 dark:text-slate-300 ml-1">
                                    Username or Email
                                </label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary transition-colors">
                                        <span class="material-symbols-outlined text-xl">person</span>
                                    </div>
                                    <input
                                        type="text"
                                        placeholder="e.g. j.doe@example.com"
                                        class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg py-3.5 pl-11 pr-4 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none"
                                    />
                                </div>
                            </div> --}}

                            <!-- Password -->
                            {{-- <div class="space-y-2">
                                <div class="flex justify-between items-center px-1">
                                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">
                                        Password
                                    </label>
                                    <a href="#" class="text-sm font-medium text-primary hover:underline transition-all">
                                        Forgot Password?
                                    </a>
                                </div>

                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary transition-colors">
                                        <span class="material-symbols-outlined text-xl">lock</span>
                                    </div>

                                    <input
                                        type="password"
                                        placeholder="••••••••"
                                        class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg py-3.5 pl-11 pr-12 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none"
                                    />

                                    <button
                                        type="button"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors"
                                    >
                                        <span class="material-symbols-outlined text-xl">visibility</span>
                                    </button>
                                </div>
                            </div> --}}

                            <!-- Remember -->
                            {{-- <div class="flex items-center">
                                <input
                                    id="remember-me"
                                    name="remember-me"
                                    type="checkbox"
                                    class="h-5 w-5 rounded border-slate-300 dark:border-slate-700 text-primary focus:ring-primary transition-all cursor-pointer"
                                />
                                <label for="remember-me" class="ml-3 text-sm text-slate-600 dark:text-slate-400">
                                    Remember this device for 30 days
                                </label>
                            </div> --}}

                            <!-- Submit -->
                            {{-- <button
                                type="submit"
                                class="w-full bg-primary hover:bg-primary/90 text-white font-bold py-4 rounded-lg shadow-lg shadow-primary/20 transition-all flex items-center justify-center gap-2 group"
                            >
                                <span>Sign In to Portal</span>
                                <span class="material-symbols-outlined text-lg group-hover:translate-x-1 transition-transform">
                                    arrow_forward
                                </span>
                            </button> --}}
                            <a
                                href="{{ url('/auth/google') }}"
                                class="w-full bg-primary hover:bg-primary/90 text-white font-bold py-4 rounded-lg shadow-lg shadow-primary/20 transition-all flex items-center justify-center gap-2 group"
                            >
                                <span>Login with Google</span>
                                <span class="material-symbols-outlined text-lg group-hover:translate-x-1 transition-transform">
                                    arrow_forward
                                </span>
                            </a>
                        </form>

                        <div class="mt-12 text-center border-t border-slate-100 dark:border-slate-800 pt-8">
                            <p class="text-sm text-slate-500 dark:text-slate-400">
                                Need help? Contact the
                                <a href="#" class="text-primary font-medium hover:underline">
                                    Association Support Team
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <footer class="p-6 text-center lg:px-20">
                <div class="flex flex-wrap justify-center gap-6 text-xs font-medium text-slate-400 uppercase tracking-widest">
                    <a href="#" class="hover:text-primary transition-colors">Terms of Service</a>
                    <a href="#" class="hover:text-primary transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-primary transition-colors">Security Standards</a>
                    <a href="#" class="hover:text-primary transition-colors">Help Center</a>
                </div>
            </footer>

        </div>
    </div>
</body>
</html>