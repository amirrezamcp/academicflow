<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AcademicFlow - @yield('title', 'پنل')</title>

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="bg-gray-100 text-gray-800 antialiased">

<header class="bg-blue-600 text-white p-4 shadow-md">
    <div class="container mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
        <h1 class="text-lg font-bold">AcademicFlow</h1>

        <nav class="flex flex-wrap gap-4 text-sm">
            <a href="{{ route('masters.index') }}" class="hover:underline">استادها</a>
            <a href="{{ route('lessons.index') }}" class="hover:underline">دروس</a>
            <a href="{{ route('students.index') }}" class="hover:underline">دانشجوها</a>
            <a href="{{ route('presentations.index') }}" class="hover:underline">ارائه‌ها</a>
            <a href="{{ route('selections.index') }}" class="hover:underline">انتخاب واحد</a>
        </nav>
    </div>
</header>

<main class="container mx-auto py-6 page-animate">
    @if(session('success'))
        <div class="mb-4 p-3 rounded-lg bg-green-50 text-green-800 border border-green-100 alert-message shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @yield('content')
</main>

<footer class="bg-gray-200 text-gray-700 p-4 text-center mt-8">
    © {{ date('Y') }} AcademicFlow
</footer>

{{-- JS --}}
<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')

</body>
</html>
