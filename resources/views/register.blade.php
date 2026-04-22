<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <title>Member Registration | Provident Fund Association</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;900&display=swap" rel="stylesheet" />
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
                        "display": ["Public Sans", "sans-serif"]
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

    <style>
        body {
            font-family: 'Public Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen flex flex-col">

    <!-- Header -->
    <header class="w-full px-6 py-4 flex justify-between items-center bg-white dark:bg-slate-900 border-b border-primary/10">
        <div class="flex items-center gap-2">
            <img 
                alt="Provident Fund Association Logo"
                class="h-10 w-auto"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuAZy3Y9nko3ZaNssdvs6e_S-68QXRUhPiVNkeGYnrGC_9-gXm8BcX3XeRzT3M7FIITdCfZSfT_9pGJg7WKxx-PXbXV0-kPWYj5LQ3OhlSP_WyvX7-BXQdffRMMcy7A1Eq31ncUANLeTWRC3pbE1ibmosyvmPmblIreT5IQwAmw6ZZcCat1EC07tor9_N0vAK1ZgaAE2QZCgJbShc8LmK-koc4r1fj0oMrgYRcOjOn5aGUbmTi58PVyPILdIndH23PUtM9rPvVqbP_8"
            />
            <span class="text-xl font-black tracking-tight text-primary">PFA</span>
        </div>

        <div class="text-sm font-medium">
            Already a member?
            <a class="text-primary hover:underline font-bold ml-1" href="#">Login here</a>
        </div>
    </header>

    <!-- Main -->
    <main class="flex-grow flex items-center justify-center py-12 px-4">
        <div class="max-w-[1000px] w-full grid grid-cols-1 lg:grid-cols-2 bg-white dark:bg-slate-900 rounded-xl shadow-xl overflow-hidden border border-primary/5">

            <!-- Left Panel -->
            <div class="hidden lg:block relative bg-primary/5 p-12">
                <div class="absolute inset-0 bg-gradient-to-br from-primary/20 to-transparent"></div>

                <div class="relative z-10 flex flex-col h-full justify-between">
                    <div>
                        <h1 class="text-4xl font-black text-slate-900 dark:text-white leading-tight mb-6">
                            Secure Your Future with PFA
                        </h1>

                        <p class="text-slate-600 dark:text-slate-400 text-lg leading-relaxed mb-8">
                            Join over 50,000 members managing their retirement savings with transparency and professional oversight.
                        </p>

                        <ul class="space-y-4">
                            <li class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary bg-primary/10 p-1 rounded-full text-sm">check</span>
                                <span class="font-medium text-slate-700 dark:text-slate-300">Automated Monthly Contributions</span>
                            </li>

                            <li class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary bg-primary/10 p-1 rounded-full text-sm">check</span>
                                <span class="font-medium text-slate-700 dark:text-slate-300">Real-time Portfolio Tracking</span>
                            </li>

                            <li class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary bg-primary/10 p-1 rounded-full text-sm">check</span>
                                <span class="font-medium text-slate-700 dark:text-slate-300">Tax-efficient Savings Growth</span>
                            </li>
                        </ul>
                    </div>

                    <div 
                        class="w-full h-48 rounded-lg overflow-hidden bg-center bg-cover border border-primary/10"
                        style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCttyMxFMFFMIrFIOz2wPCQfzEajHBTY-HW1okFBLIy8bquLnE-5BNn3glzuPWaCDNserU5Yc6mHlmhYpatVwT9vWh7Rf-lSMnjt3zF0itIKR5s0AHbM4XKU4P0bU7RTDdTWQQFaLLVf3R_CnVDHmF4O_Qb2UEiMd9SAWgSnZmTttwFmcsRZNJxPB1efjZ4FsrSDYITUJqAe7k0Nle9tGRLGYlYAwigkw0Ko9ChniK0aqjjzg2pWUPFjMhLTIAVSXQt2uVrz-cSXmc');">
                    </div>
                </div>
            </div>

            <!-- Right Panel (Form) -->
            <div class="p-8 lg:p-12">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Member Registration</h2>
                    <p class="text-slate-500 dark:text-slate-400 mt-1">
                        Please fill in your professional details below.
                    </p>
                </div>

                <form class="space-y-5">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-2">
                            <label class="text-sm font-semibold">Full Name</label>
                            <input class="w-full px-4 py-3 rounded-lg border border-primary/20" placeholder="John Doe" type="text" />
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="text-sm font-semibold">Member ID</label>
                            <input class="w-full px-4 py-3 rounded-lg border border-primary/20" placeholder="PF-12345678" type="text" />
                        </div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-semibold">Email Address</label>
                        <input class="w-full px-4 py-3 rounded-lg border border-primary/20" placeholder="email@organization.com" type="email" />
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-semibold">Phone Number</label>
                        <input class="w-full px-4 py-3 rounded-lg border border-primary/20" placeholder="+1 (555) 000-0000" type="tel" />
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-semibold">Create Password</label>
                        <input class="w-full px-4 py-3 rounded-lg border border-primary/20" placeholder="••••••••" type="password" />
                    </div>

                    <button class="w-full bg-primary text-white font-bold py-4 rounded-lg">
                        Complete Registration
                    </button>

                </form>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full py-6 px-6 text-center text-sm text-slate-500">
        <p>© 2024 Provident Fund Association. All rights reserved.</p>
    </footer>

</body>
</html>