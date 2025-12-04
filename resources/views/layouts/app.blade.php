<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AcademicFlow</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.3/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-800">

    <header class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex justify-between">
            <h1 class="text-xl font-bold">AcademicFlow</h1>
            <nav class="space-x-4">
                <a href="{{ route('masters.index') }}" class="hover:underline">استادها</a>
                <a href="{{ route('lessons.index') }}" class="hover:underline">دروس</a>
                <a href="{{ route('presentations.index') }}" class="hover:underline">ارائه‌ها</a>
                <a href="{{ route('students.index') }}" class="hover:underline">دانش‌آموزان</a>
                <a href="{{ route('selections.index') }}" class="hover:underline">انتخاب واحد</a>
            </nav>
        </div>
    </header>

    <main class="container mx-auto py-6">
        @yield('content')
    </main>

    <footer class="bg-gray-200 text-gray-700 p-4 text-center">
        © 2025 AcademicFlow
    </footer>

</body>
</html>
