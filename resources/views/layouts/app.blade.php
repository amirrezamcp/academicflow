<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AcademicFlow - @yield('title', 'پنل')</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        },
                        accent: {
                            500: '#8b5cf6',
                            600: '#7c3aed',
                        }
                    },
                    fontFamily: {
                        'sans': ['Vazirmatn', 'system-ui', '-apple-system', 'sans-serif'],
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'gradient': 'gradient 3s ease infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        },
                        gradient: {
                            '0%, 100%': { backgroundPosition: '0% 50%' },
                            '50%': { backgroundPosition: '100% 50%' },
                        }
                    }
                }
            }
        }
    </script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vazirmatn@33.003/font.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="bg-gradient-to-br from-gray-50 to-blue-50 text-gray-800 font-sans antialiased min-h-screen">

<header class="bg-gradient-to-r from-primary-600 to-accent-600 text-white shadow-xl">
    <div class="container mx-auto px-4 py-4">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="relative">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center animate-float">
                        <i class="fas fa-graduation-cap text-xl"></i>
                    </div>
                    <div class="absolute -top-1 -right-1 w-3 h-3 bg-yellow-400 rounded-full animate-pulse"></div>
                </div>
                <h1 class="text-xl md:text-2xl font-bold tracking-tight">
                    Academic<span class="text-yellow-300">Flow</span>
                </h1>
            </div>

            <nav class="flex flex-wrap gap-2 md:gap-4">
                @php
                    $navItems = [
                        ['route' => 'masters.index', 'icon' => 'fas fa-chalkboard-teacher', 'text' => 'استادها'],
                        ['route' => 'lessons.index', 'icon' => 'fas fa-book-open', 'text' => 'دروس'],
                        ['route' => 'students.index', 'icon' => 'fas fa-user-graduate', 'text' => 'دانشجوها'],
                        ['route' => 'presentations.index', 'icon' => 'fas fa-presentation', 'text' => 'ارائه‌ها'],
                        ['route' => 'selections.index', 'icon' => 'fas fa-clipboard-check', 'text' => 'انتخاب واحد'],
                    ];
                @endphp

                @foreach($navItems as $item)
                    <a href="{{ route($item['route']) }}"
                       class="flex items-center gap-2 px-4 py-2 rounded-lg transition-all duration-300
                              hover:bg-white/20 hover:shadow-lg hover:-translate-y-0.5
                              {{ request()->routeIs($item['route'].'*') ? 'bg-white/25 shadow-md' : '' }}">
                        <i class="{{ $item['icon'] }}"></i>
                        <span class="text-sm font-medium">{{ $item['text'] }}</span>
                    </a>
                @endforeach
            </nav>

            <div class="flex items-center gap-3">
                <div class="hidden md:block text-sm opacity-90">
                    <i class="fas fa-calendar-day mr-1"></i>
                    {{ verta(now())->format('Y/m/d') }}
                </div>
                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center hover:bg-white/30 transition cursor-pointer">
                    <i class="fas fa-user"></i>
                </div>
            </div>
        </div>
    </div>
</header>

<main class="container mx-auto px-4 py-8">
    @hasSection('breadcrumb')
        <nav class="mb-6 text-sm text-gray-600">
            @yield('breadcrumb')
        </nav>
    @endif

    @hasSection('page-title')
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                @yield('page-title')
                <span class="h-1 w-12 bg-gradient-to-r from-primary-500 to-accent-500 rounded-full"></span>
            </h1>
            @hasSection('page-subtitle')
                <p class="text-gray-600 mt-2">@yield('page-subtitle')</p>
            @endif
        </div>
    @endif

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-gradient-to-r from-green-50 to-emerald-50
                    border border-green-200 shadow-sm alert-message flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-check text-green-600"></i>
                </div>
                <span class="text-green-800 font-medium">{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 rounded-xl bg-gradient-to-r from-red-50 to-pink-50
                    border border-red-200 shadow-sm flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-exclamation text-red-600"></i>
                </div>
                <span class="text-red-800 font-medium">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <div class="page-animate">
        @yield('content')
    </div>
</main>

<footer class="mt-12 bg-gradient-to-r from-gray-900 to-gray-800 text-white py-8">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-xl font-bold mb-4 flex items-center gap-2">
                    <i class="fas fa-university"></i>
                    AcademicFlow
                </h3>
                <p class="text-gray-400 text-sm">
                    سامانه مدیریت آموزشی پیشرفته برای دانشگاه‌ها و مراکز آموزش عالی
                </p>
            </div>

            <div>
                <h4 class="font-bold mb-4">لینک‌های سریع</h4>
                <ul class="space-y-2 text-gray-400">
                    @foreach($navItems as $item)
                        <li>
                            <a href="{{ route($item['route']) }}" class="hover:text-white transition">
                                <i class="fas fa-arrow-left ml-2 text-xs"></i>
                                {{ $item['text'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h4 class="font-bold mb-4">تماس با ما</h4>
                <div class="space-y-3 text-gray-400">
                    <p class="flex items-center gap-2">
                        <i class="fas fa-envelope"></i>
                        support@academicflow.ir
                    </p>
                    <p class="flex items-center gap-2">
                        <i class="fas fa-phone"></i>
                        ۰۲۱-۱۲۳۴۵۶۷۸
                    </p>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-500 text-sm">
            © {{ date('Y') }} AcademicFlow - تمامی حقوق محفوظ است
            <div class="mt-2">
                <span class="inline-block w-2 h-2 bg-primary-500 rounded-full animate-pulse"></span>
                <span class="mx-2">نسخه ۱.۰.۰</span>
                <span class="inline-block w-2 h-2 bg-accent-500 rounded-full animate-pulse"></span>
            </div>
        </div>
    </div>
</footer>

{{-- JS --}}
<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')

</body>
</html>
