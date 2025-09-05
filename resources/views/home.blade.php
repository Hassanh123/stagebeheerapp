<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stagebeheer App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-white shadow">
        <div class="max-w-6xl mx-auto py-6 px-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Stagebeheer App</h1>
            <nav class="space-x-4">
                <a href="/" class="text-gray-600 hover:text-gray-800 font-medium">Home</a>
                <a href="/dashboard" class="text-gray-600 hover:text-gray-800 font-medium">Dashboard</a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 p-8">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-4xl font-extrabold mb-6 text-center text-gray-800">Welkom bij Stagebeheer</h2>
            <p class="text-center mb-12 text-gray-500 text-lg">
                Gebruik het onderstaande menu om snel toegang te krijgen tot Bedrijven, Stages, Tags, Studenten en Docenten.
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Bedrijven -->
                <a href="{{ route('companies.index') }}"
                    class="group block p-8 bg-white rounded-xl shadow-md hover:shadow-2xl transition transform hover:-translate-y-1">
                    <h3 class="font-semibold text-xl mb-2 text-blue-700 group-hover:text-blue-800 transition">Bedrijven</h3>
                    <p class="text-gray-600 text-sm group-hover:text-gray-800 transition">Bekijk en beheer alle bedrijven.</p>
                </a>

                <!-- Stages -->
                <a href="{{ route('stages.index') }}"
                    class="group block p-8 bg-white rounded-xl shadow-md hover:shadow-2xl transition transform hover:-translate-y-1">
                    <h3 class="font-semibold text-xl mb-2 text-green-700 group-hover:text-green-800 transition">Stages</h3>
                    <p class="text-gray-600 text-sm group-hover:text-gray-800 transition">Bekijk en beheer alle stages.</p>
                </a>

                <!-- Tags -->
                <a href="{{ route('tags.index') }}"
                    class="group block p-8 bg-white rounded-xl shadow-md hover:shadow-2xl transition transform hover:-translate-y-1">
                    <h3 class="font-semibold text-xl mb-2 text-yellow-700 group-hover:text-yellow-800 transition">Tags</h3>
                    <p class="text-gray-600 text-sm group-hover:text-gray-800 transition">Bekijk en beheer alle tags.</p>
                </a>

                <!-- Studenten -->
                <a href="{{ route('students.index') }}"
                    class="group block p-8 bg-white rounded-xl shadow-md hover:shadow-2xl transition transform hover:-translate-y-1">
                    <h3 class="font-semibold text-xl mb-2 text-purple-700 group-hover:text-purple-800 transition">Studenten</h3>
                    <p class="text-gray-600 text-sm group-hover:text-gray-800 transition">Bekijk en beheer alle studenten.</p>
                </a>

                <!-- Docenten -->
                <a href="{{ route('teachers.index') }}"
                    class="group block p-8 bg-white rounded-xl shadow-md hover:shadow-2xl transition transform hover:-translate-y-1">
                    <h3 class="font-semibold text-xl mb-2 text-pink-700 group-hover:text-pink-800 transition">Docenten</h3>
                    <p class="text-gray-600 text-sm group-hover:text-gray-800 transition">Bekijk en beheer alle docenten.</p>
                </a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white shadow mt-8">
        <div class="max-w-6xl mx-auto py-4 px-4 text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} Stagebeheer App. Alle rechten voorbehouden.
        </div>
    </footer>

</body>

</html>
