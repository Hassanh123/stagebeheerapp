<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StageZoeker - Beschikbare Stages</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-b from-indigo-50 via-white to-gray-50 min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-indigo-600 text-white shadow">
        <div class="max-w-7xl mx-auto px-6 py-6 flex justify-between items-center">
            <h1 class="text-3xl font-bold tracking-tight">StageZoeker</h1>
            <nav class="space-x-6">
                <a href="{{ route('home') }}" class="hover:underline font-medium">Home</a>
                <a href="/admin" class="hover:underline font-medium">Dashboard</a>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="py-12 bg-indigo-50">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl font-extrabold text-indigo-800 mb-4">Vind jouw perfecte stage!</h2>
            <p class="text-indigo-600 text-lg">Bekijk alle beschikbare stages en ontdek waar jouw talent het best tot zijn recht komt.</p>
        </div>
    </section>

    <!-- Success / Error Messages -->
    <div class="max-w-7xl mx-auto px-6 mt-6">
        @if (session('success'))
            <div class="mb-6 text-green-800 bg-green-100 p-4 rounded-xl shadow text-center">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-6 text-red-800 bg-red-100 p-4 rounded-xl shadow text-center">
                {{ session('error') }}
            </div>
        @endif
    </div>

    <!-- Beschikbare Stages -->
    <main class="flex-1 py-10 px-6">
        <div class="max-w-7xl mx-auto space-y-6">
            <h2 class="text-3xl font-extrabold text-indigo-800 mb-6 border-b-2 border-indigo-300 pb-2">
                Beschikbare Stages
            </h2>

            @forelse($stages as $stage)
                <div class="bg-white rounded-3xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-1 hover:scale-102 p-6 flex flex-col md:flex-row justify-between items-start gap-6">

                    <!-- Stage Info -->
                    <div class="flex-1 space-y-2">
                        <h3 class="text-2xl font-bold text-indigo-800">{{ $stage->titel }}</h3>
                        <p class="text-gray-600">{{ $stage->beschrijving ?? 'Geen beschrijving beschikbaar' }}</p>

                        <div class="flex flex-wrap gap-4 text-gray-700 mt-2">
                            @if ($stage->company)
                                <div><span class="font-medium">Bedrijf:</span> {{ $stage->company->naam }}</div>
                            @endif
                            @if ($stage->teacher)
                                <div><span class="font-medium">Begeleider:</span> {{ $stage->teacher->naam }}</div>
                            @endif
                            @if ($stage->tags && count($stage->tags))
                                <div><span class="font-medium">Tags:</span> {{ implode(', ', $stage->tags->pluck('naam')->toArray()) }}</div>
                            @endif
                        </div>
                    </div>

                    <!-- Stage Status / Kies knop -->
                    <div class="mt-4 md:mt-0 flex-shrink-0 w-full md:w-auto text-center">
                        @if ($stage->status === 'vrij')
                            <form action="{{ route('stages.choose', $stage->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full md:w-auto bg-green-200 text-green-800 font-semibold py-2 px-6 rounded-xl hover:bg-green-300">
                                    Kies deze stage
                                </button>
                            </form>
                        @else
                            <div class="bg-gray-300 text-gray-700 font-semibold py-2 px-6 rounded-xl">
                                {{ ucfirst($stage->status) }}
                            </div>
                        @endif
                    </div>

                </div>
            @empty
                <p class="text-center text-gray-500">Er zijn momenteel geen stages beschikbaar.</p>
            @endforelse
        </div>
    </main>

    <!-- Beschikbare Bedrijven -->
    <section class="py-12 bg-indigo-100">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-3xl font-extrabold text-indigo-800 mb-6 border-b-2 border-indigo-300 pb-2">Beschikbare Bedrijven</h2>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($companies as $company)
                    <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition space-y-2">
                        <h3 class="text-xl font-bold text-indigo-700">{{ $company->naam }}</h3>
                        <p class="text-gray-600">{{ $company->beschrijving ?? 'Geen beschrijving beschikbaar' }}</p>
                        <p class="text-sm text-gray-500">
                            <span class="font-medium">Adres:</span> {{ $company->adres ?? 'Onbekend' }}
                        </p>
                    </div>
                @empty
                    <p class="text-gray-500">Er zijn momenteel geen bedrijven geregistreerd.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Mijn Keuze Sectie -->
    @if ($mijnKeuze ?? false)
        <section class="py-12 bg-white border-t border-gray-200">
            <div class="max-w-7xl mx-auto px-6">
                <h2 class="text-3xl font-extrabold text-indigo-800 mb-6 border-b-2 border-indigo-300 pb-2">Mijn Keuze (BPV)</h2>

                <div class="bg-indigo-50 rounded-2xl shadow-md p-6 space-y-4">
                    <h3 class="text-2xl font-bold text-indigo-700">{{ $mijnKeuze->titel }}</h3>
                    <p class="text-gray-600">{{ $mijnKeuze->beschrijving ?? 'Geen beschrijving beschikbaar' }}</p>

                    <div class="flex flex-wrap gap-4 text-gray-700">
                        <div><span class="font-medium">Bedrijf:</span> {{ $mijnKeuze->company->naam ?? 'Onbekend' }}</div>
                        <div><span class="font-medium">Begeleider:</span> {{ $mijnKeuze->teacher->naam ?? 'Nog niet gekoppeld' }}</div>
                        @if ($mijnKeuze->tags && count($mijnKeuze->tags))
                            <div><span class="font-medium">Tags:</span> {{ implode(', ', $mijnKeuze->tags->pluck('naam')->toArray()) }}</div>
                        @endif
                    </div>

                    <div class="text-center">
                        @if ($mijnKeuze->status === 'vrij')
                            <span class="bg-yellow-200 text-yellow-800 px-4 py-2 rounded-xl font-semibold">In behandeling</span>
                        @elseif ($mijnKeuze->status === 'bezet')
                            <span class="bg-green-200 text-green-800 px-4 py-2 rounded-xl font-semibold">Goedgekeurd</span>
                        @elseif ($mijnKeuze->status === 'afgekeurd')
                            <span class="bg-red-200 text-red-800 px-4 py-2 rounded-xl font-semibold">Afgewezen</span>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Footer -->
    <footer class="bg-indigo-600 text-white mt-auto">
        <div class="max-w-7xl mx-auto py-6 px-6 text-center text-sm">
            &copy; {{ date('Y') }} StageZoeker. Alle rechten voorbehouden.
        </div>
    </footer>

</body>
</html>
