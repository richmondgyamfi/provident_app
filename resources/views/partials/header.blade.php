<header
    class="
    sticky top-0 z-10
    bg-white/80 dark:bg-slate-900/80 backdrop-blur-md
    border-b border-slate-200 dark:border-slate-800
    px-4 sm:px-8 py-4
    flex items-center justify-between gap-4
">
    <div class="flex items-center gap-3 min-w-0">
        <!-- Hamburger – mobile only -->
        <button
            class="lg:hidden shrink-0 size-10 flex items-center justify-center rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors"
            onclick="openSidebar()" aria-label="Open menu">
            <span class="material-symbols-outlined">menu</span>
        </button>
        <div class="min-w-0">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white leading-none">@yield('title', 'PF Management')</h2>
            <p class="text-sm text-slate-500 hidden sm:block">Welcome back,
                <span class="capitalize">{{ strtolower(auth()->user()->fname) }}</span>
                Here's
                what's
                happening today.
            </p>
        </div>
    </div>

    <div class="flex items-center gap-2 sm:gap-4 shrink-0">
        <!-- Search – hidden on very small screens -->
        {{-- <div class="relative hidden md:block">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">
                search
            </span>
            <input
                class="pl-10 pr-4 py-2 bg-slate-100 dark:bg-slate-800 border-none rounded-lg text-sm w-64 focus:ring-2 focus:ring-primary/20"
                placeholder="Search members, transactions…" type="text" />
        </div> --}}

        <button onclick="toggleTheme()" aria-label="Toggle dark mode" title="Toggle dark mode"
            class="
                size-10 flex items-center justify-center
                rounded-lg bg-slate-100 dark:bg-slate-800
                text-slate-600 dark:text-slate-400
                hover:bg-slate-200 dark:hover:bg-slate-700
                transition-colors
            ">
            <span class="material-symbols-outlined dark:hidden">dark_mode</span>
            <span class="material-symbols-outlined hidden dark:block">light_mode</span>
        </button>

        <button
            class="size-10 flex items-center justify-center rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
            <span class="material-symbols-outlined">notifications</span>
        </button>

        {{-- <button
            class="bg-accent-gold text-slate-900 px-3 sm:px-4 py-2 rounded-lg text-sm font-semibold flex items-center gap-1 sm:gap-2 hover:bg-accent-gold/90 transition-colors shadow-lg shadow-accent-gold/20">
            <span class="material-symbols-outlined text-base">add</span>
            <span class="hidden sm:inline">New Entry</span>
        </button> --}}
    </div>
</header>
