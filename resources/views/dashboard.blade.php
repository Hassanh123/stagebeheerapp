<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - {{ $user->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen font-sans">

    <!-- Navbar -->
    <nav class="bg-white shadow p-4 flex justify-between items-center">
        <div>
            <a href="{{ route('home') }}" class="font-bold text-xl text-indigo-600 hover:text-indigo-800 transition">Stagebeheer</a>
        </div>
        <div class="flex items-center gap-4">
            <img class="w-10 h-10 rounded-full border-2 border-indigo-500" 
                 src="{{ $user->photo_url ?? 'https://i.pravatar.cc/150?img=' . rand(1,70) }}" 
                 alt="{{ $user->name }}">
            <span class="font-medium">{{ $user->name }} ({{ ucfirst($user->role) }})</span>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-500 px-3 py-1 text-white rounded hover:bg-red-600 transition">
                    Uitloggen
                </button>
            </form>
        </div>
    </nav>

    <!-- Dashboard content -->
    <main class="p-6 max-w-4xl mx-auto">

        <!-- Header -->
        <header class="mb-6">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">Welkom, {{ $user->name }}!</h1>
            <p class="text-gray-600">Je bent ingelogd als <strong>{{ ucfirst($user->role) }}</strong>.</p>
        </header>

        <!-- Profielsectie -->
        <section class="bg-white shadow rounded-lg p-6">
            <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                
                <!-- Avatar -->
                <img class="w-28 h-28 rounded-full border-4 border-indigo-500" 
                     src="{{ $user->photo_url ?? 'https://i.pravatar.cc/150?img=' . rand(1,70) }}" 
                     alt="{{ $user->name }}">

                <!-- Profiel info -->
                <div class="flex-1">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Persoonlijk profiel</h2>
                    <p class="mb-2"><strong>Naam:</strong> {{ $user->name }}</p>
                    <p class="mb-2"><strong>Email:</strong> {{ $user->email }}</p>

                    @if($user->role === 'student' && $student)
                        <p class="mb-2"><strong>Studentnummer:</strong> {{ $student->student_number ?? 'Niet beschikbaar' }}</p>
                    @endif

                    <p class="mb-2"><strong>Rol:</strong> {{ ucfirst($user->role) }}</p>

                    <!-- Knoppen -->
                    <div class="mt-4 flex gap-4 flex-wrap">
                        <a href="{{ route('home') }}" 
                           class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300 transition">Terug naar home</a>

                        <a href="{{ route('profile.edit') }}" 
                           class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600 transition">Bewerk profiel</a>
                    </div>
                </div>

            </div>
        </section>

        <!-- Teacher extra info (optioneel) -->
        @if($user->role === 'teacher')
            <section class="bg-white shadow rounded-lg p-6 mt-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Dashboard statistieken</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-indigo-500 text-white rounded-lg shadow-lg p-6">
                        <h3 class="text-lg font-bold">Open Stages</h3>
                        <p class="text-3xl">{{ \App\Models\Stage::where('status', 'vrij')->count() }}</p>
                    </div>
                    <div class="bg-green-500 text-white rounded-lg shadow-lg p-6">
                        <h3 class="text-lg font-bold">Closed Stages</h3>
                        <p class="text-3xl">{{ \App\Models\Stage::where('status', 'op slot')->count() }}</p>
                    </div>
                    <div class="bg-yellow-500 text-white rounded-lg shadow-lg p-6">
                        <h3 class="text-lg font-bold">Total Tags</h3>
                        <p class="text-3xl">{{ \App\Models\Tag::count() }}</p>
                    </div>
                </div>
            </section>
        @endif

    </main>

</body>
</html>
