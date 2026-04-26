<!-- ── Sidebar Navigation ─────────────────────────────────────────── -->
<aside id="sidebar"
    class="
                fixed inset-y-0 left-0 z-30
                w-64 shrink-0
                border-r border-slate-200 dark:border-slate-800
                bg-white dark:bg-slate-900
                flex flex-col
                -translate-x-full
                lg:static lg:translate-x-0
            ">
    <!-- Logo -->
    <div class="p-6 flex items-center gap-3">
        <div class="bg-primary rounded-lg size-10 flex items-center justify-center text-white shrink-0">
            <span class="material-symbols-outlined">account_balance</span>
        </div>
        <div class="flex flex-col">
            <h1 class="text-slate-900 dark:text-white text-base font-bold leading-none">Provident Fund</h1>
            <p class="text-slate-500 text-xs font-medium">Staff Portal</p>
        </div>
        <!-- Close button – mobile only -->
        <button class="ml-auto lg:hidden text-slate-400 hover:text-slate-600" onclick="closeSidebar()"
            aria-label="Close menu">
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>

    <!-- Nav links -->
    <nav class="flex-1 px-4 py-2 space-y-1 overflow-y-auto">

                @php
                    $activeClass = 'flex items-center gap-3 px-3 py-2 rounded-lg bg-primary/10 text-primary font-semibold';
                    $inactiveClass = 'flex items-center gap-3 px-3 py-2 rounded-lg text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors';
@endphp

                {{-- Member Dashboard --}}
                @if(auth()->user()->hasRole('staff') || auth()->user()->hasRole('director') || auth()->user()->hasRole('vc') || auth()->user()->hasRole('payroll'))
                <a class="{{ request()->routeIs('dashboard') ? $activeClass : $inactiveClass }}" href="{{ route('members.index') }}">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span class="text-sm">Dashboard</span>
                </a>
                @endif

                {{-- Admin Dashboard --}}
                @if(auth()->user()->isAdmin())
                <a class="{{ request()->routeIs('admin.admin-dashboard') ? $activeClass : $inactiveClass }}" href="{{ route('admin.admin-dashboard') }}">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span class="text-sm">Admin Dashboard</span>
                </a>
                @endif

                <div class="pt-2 pb-2 text-[10px] uppercase font-bold tracking-wider text-slate-400 px-3">
                    Staff
                </div>
                <a class="{{ request()->routeIs('membership-form') ? $activeClass : $inactiveClass }}" href="{{ route('membership-form') }}">
                    <span class="material-symbols-outlined">groups</span>
                    <span class="text-sm">Membership Form</span>
                </a>
                <a class="{{ request()->routeIs('loans.*') ? $activeClass : $inactiveClass }}" href="{{ route('loan-application') }}">

                    <span class="material-symbols-outlined">receipt_long</span>
                    <span class="text-sm">Loans</span>
                </a>

                <div class="pt-2 pb-2 text-[10px] uppercase font-bold tracking-wider text-slate-400 px-3">
                    Admin
                </div>
                <a class="{{ request()->routeIs('admin.loans.index') ? $activeClass : $inactiveClass }}" href="{{ route('admin.loans.index') }}">
                    <span class="material-symbols-outlined">receipt_long</span>
                    <span class="text-sm">Loans</span>
                </a>
                <a class="{{ request()->routeIs('admin.withdrawals.*') ? $activeClass : $inactiveClass }}" href="{{ route('admin.withdrawals.index') }}">
                    <span class="material-symbols-outlined">wallet</span>
                    <span class="text-sm">Withdrawals</span>
                </a>

                <a class="{{ request()->routeIs('admin.membership-form-admin') ? $activeClass : $inactiveClass }}" href="{{ route('admin.membership-form-admin') }}">
                    <span class="material-symbols-outlined">groups</span>
                    <span class="text-sm">Membership Form</span>
                </a>

                {{-- <a class="{{ request()->routeIs('payroll.*') ? $activeClass : $inactiveClass }}" href="admin/staff-contribution">
                    <span class="material-symbols-outlined">payments</span>
                    <span class="text-sm">Staff Payroll &amp; Contribution</span>
                </a> --}}

                <a class="{{ request()->routeIs('payroll-contribution') ? $activeClass : $inactiveClass }}" href="{{ route('payroll-contribution.create') }}">
                    <span class="material-symbols-outlined">payments</span>
                    <span class="text-sm">Payroll &amp; Contribution</span>
                </a>

                <a class="{{ request()->routeIs('admin.loan-repayment-uploads.*') ? $activeClass : $inactiveClass }}" href="{{ route('admin.loan-repayment-uploads.index') }}">
                    <span class="material-symbols-outlined">payments</span>
                    <span class="text-sm">Loan Repayments</span>
                </a>

                <a class="{{ request()->routeIs('withdrawals.*') ? $activeClass : $inactiveClass }}" href="withdrawal-request">
                    <span class="material-symbols-outlined">wallet</span>
                    <span class="text-sm">Withdrawals</span>
                </a>

                <div class="pt-4 pb-2 text-[10px] uppercase font-bold tracking-wider text-slate-400 px-3">
                    Reports
                </div>

                <a class="{{ request()->routeIs('reports.financial*') ? $activeClass : $inactiveClass }}" href="staff-statement">
                    <span class="material-symbols-outlined">analytics</span>
                    <span class="text-sm">Financial Summary</span>
                </a>

                <a class="{{ request()->routeIs('reports.audit*') ? $activeClass : $inactiveClass }}" href="#">
                    <span class="material-symbols-outlined">description</span>
                    <span class="text-sm">Audit Log</span>
                </a>

            </nav>

    <!-- Bottom: dark mode toggle + user section -->
    <div class="p-4 border-t border-slate-200 dark:border-slate-800">

        <a class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors"
            href="#">
            <span class="material-symbols-outlined">settings</span>
            <span class="text-sm font-medium">Settings</span>
        </a>

        <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit"
                class="flex items-center gap-3 w-full px-3 py-2 rounded-lg text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors text-left">
                <span class="material-symbols-outlined">logout</span>
                <span class="text-sm font-medium">Logout</span>
            </button>
        </form>

        <!-- ── Dark mode toggle row ──────────────────────────────── -->
        <div class="mt-1 flex items-center justify-between px-3 py-2">
            <div class="flex items-center gap-2 text-slate-600 dark:text-slate-400">
                <!-- Icon swaps via JS -->
                <span class="material-symbols-outlined text-[18px]" id="sidebar-theme-icon">dark_mode</span>
                <span class="text-sm font-medium" id="sidebar-theme-label">Dark Mode</span>
            </div>

            <!-- Pill toggle -->
            <button id="sidebar-theme-toggle" onclick="toggleTheme()" aria-label="Toggle dark mode"
                class="
                            relative w-[40px] h-[22px] rounded-full
                            bg-slate-200 dark:bg-primary
                            transition-colors duration-200
                            focus:outline-none focus:ring-2 focus:ring-primary/40
                        ">
                <span
                    class="toggle-thumb absolute top-[3px] left-[3px] w-[16px] h-[16px] rounded-full bg-white shadow-sm"></span>
            </button>
        </div>

        <!-- User info -->
        <div class="mt-3 flex items-center gap-3 px-3">
            <div class="size-8 rounded-full bg-slate-200 dark:bg-slate-700 bg-cover bg-center shrink-0"
                style="background-image: url('https://ehub.ucc.edu.gh/api/photos/?tag={{ auth()->user()->staff_no }}')"
                aria-label="Administrator user profile picture"></div>
            <div class="flex-1 overflow-hidden">
                <p class="text-xs font-bold text-slate-900 dark:text-white truncate capitalize">
                    {{ strtolower(auth()->user()->fname . ' ' . auth()->user()->lname) }}</p>
                <p class="text-[10px] text-slate-500 truncate capitalize">{{ strtolower(auth()->user()->job_title) }}
                </p>
            </div>
        </div>

    </div>
</aside>
