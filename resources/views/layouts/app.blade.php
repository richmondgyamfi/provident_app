<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>@yield('title', 'PF Management') | PF Management</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />

    <!-- Tailwind config — shared across all pages -->
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary":          "#1773cf",
                        "accent-red":       "#dc2626",
                        "accent-gold":      "#eab308",
                        "background-light": "#f6f6f8",
                        "background-dark":  "#101622",
                    },
                    fontFamily: {
                        "display": ["Public Sans", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "4px",
                        "lg":      "8px",
                        "xl":      "12px",
                        "full":    "9999px"
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
    </script>

    <!-- Global styles -->
    <style>
        body {
            font-family: 'Public Sans', sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        /* Sidebar slide-in transition */
        #sidebar {
            transition: transform 0.25s ease;
        }

        /* Overlay fade */
        #sidebar-overlay {
            transition: opacity 0.25s ease;
        }

        /* Dark mode toggle pill thumb */
        .toggle-thumb {
            transition: transform 0.2s ease;
        }

        html.dark .toggle-thumb {
            transform: translateX(18px);
        }
    </style>

</head>
<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100">
    

    <!-- ── Mobile sidebar overlay ──────────────────────────────────────── -->
    <!--
        Included once in the layout. The sidebar partial and this overlay
        are controlled by the shared sidebar.js logic at the bottom.
    -->
    <div
        id="sidebar-overlay"
        class="fixed inset-0 z-20 bg-black/40 opacity-0 pointer-events-none lg:hidden"
        onclick="closeSidebar()"
    ></div>

    <!-- ── App shell ───────────────────────────────────────────────────── -->
    <div class="flex h-screen overflow-hidden">

        <!-- PARTIAL: partials/sidebar.html -->
        {{-- {{SIDEBAR}} --}}
        @include('partials.sidebar')

        <!-- ── Main column ─────────────────────────────────────────────── -->
        <main class="flex-1 overflow-y-auto min-w-0">

            <!-- PARTIAL: partials/header.html -->
            {{-- {{HEADER}} --}}
            @include('partials.header')

            <!-- ── Page content slot ───────────────────────────────────── -->
            <!--
                Each page drops its own content here.
                Wrap page content in:
                  <div class="p-4 sm:p-8 space-y-6 sm:space-y-8"> … </div>
            -->
            {{-- {{PAGE_CONTENT}} --}}
            <div class="flex-1 p-7 space-y-4 mx-auto w-full overflow-y-auto">
                @yield('content')
            </div>

        </main>

    </div>

    <!-- ── Shared sidebar toggle script ───────────────────────────────── -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('opacity-0', 'pointer-events-none');
            overlay.classList.add('opacity-100');
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('opacity-0', 'pointer-events-none');
            overlay.classList.remove('opacity-100');
        }

        // Auto-close sidebar when resizing to desktop
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) closeSidebar();
        });

         // ── Dark mode ────────────────────────────────────────────────────────
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
</body>
</html>
