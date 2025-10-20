@php
    use Illuminate\Support\Str;
    use App\Models\Stage;

    $user = auth()->user();
    $student = $user?->student;
    $mijnKeuze = null;

    if ($student && $student->stage_id) {
        $mijnKeuze = Stage::with(['company', 'teacher', 'tags'])->find($student->stage_id);
    }
@endphp

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StageZoeker - Beschikbare Stages</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="bg-gradient-to-b from-indigo-50 via-white to-gray-50 min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-indigo-600 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <img src="{{ asset('build/assets/stagebeheer.png') }}" alt="StageZoeker Logo"
                    class="h-12 w-auto rounded-md bg-white p-1">
                <h1 class="text-3xl font-bold tracking-tight drop-shadow-md">StageZoeker</h1>
            </div>
            <nav class="space-x-6">
                <a href="{{ route('home') }}" class="hover:underline hover:text-gray-200 font-medium transition">Home</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="hover:underline hover:text-gray-200 font-medium transition">Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button class="hover:underline hover:text-gray-200 font-medium transition">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:underline hover:text-gray-200 font-medium transition">Inloggen</a>
                    <a href="{{ route('register') }}" class="hover:underline hover:text-gray-200 font-medium transition">Registreren</a>
                @endauth
            </nav>
        </div>
    </header>

    <!-- Notificatie Pop-up voor Mijn Keuze -->
    @auth
        @if ($user->role === 'student' && $mijnKeuze && in_array($mijnKeuze->status, ['goedgekeurd','afgekeurd']))
            <div 
                x-data="{ show: true }"
                x-show="show"
                x-init="setTimeout(() => show = false, 5000)"
                class="fixed top-4 right-4 z-50 px-6 py-4 rounded-xl shadow-lg
                    @if($mijnKeuze->status === 'goedgekeurd') bg-green-100 text-green-800 border border-green-300
                    @elseif($mijnKeuze->status === 'afgekeurd') bg-red-100 text-red-800 border border-red-300 @endif">
                @if($mijnKeuze->status === 'goedgekeurd')
                    ✅ Je stage "{{ $mijnKeuze->titel }}" is goedgekeurd!
                @elseif($mijnKeuze->status === 'afgekeurd')
                    ❌ Je stage "{{ $mijnKeuze->titel }}" is afgekeurd!
                @endif
            </div>
        @endif
    @endauth

    <!-- Hero Section -->
    <section class="relative py-16 bg-gradient-to-b from-indigo-50 to-white border-b border-indigo-200">
        <div class="max-w-3xl mx-auto text-center px-4">
            <h1 class="text-4xl md:text-5xl font-extrabold text-indigo-900 mb-3 leading-snug">
                Ontdek jouw ideale stageplek
            </h1>
            <p class="text-indigo-700 text-base md:text-lg mb-5">
                Vind eenvoudig beschikbare stages bij topbedrijven en onderwijsinstellingen.<br>
                Controleer de status van elke stage en solliciteer direct.<br>
                <strong>Inloggen als student</strong> is vereist om te solliciteren.
            </p>
            <div class="flex justify-center mb-3">
                <a href="{{ route('dashboard') }}"
                    class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow hover:bg-indigo-700 transition">
                    Ga naar Dashboard
                </a>
            </div>
            <p class="text-indigo-500 text-sm">
                Alle stages zijn gecontroleerd en up-to-date. Mis geen kans op jouw volgende leerervaring!
            </p>
        </div>
    </section>

    <!-- Main Content -->
    <main class="flex-1 py-8 px-4">
        <div class="max-w-7xl mx-auto space-y-5">
            <h2 class="text-3xl font-extrabold text-indigo-800 mb-4 border-b-2 border-indigo-300 pb-2">Beschikbare Stages</h2>

            <!-- Filter formulier -->
            <form method="GET" action="{{ route('home') }}" class="mb-4 flex flex-col md:flex-row items-center gap-3">
                <div class="flex items-center gap-2">
                    <label for="tag" class="text-gray-700 font-medium">Filter op tag:</label>
                    <select name="tag" id="tag"
                        class="rounded-xl border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        onchange="this.form.submit()">
                        <option value="">-- Alle tags --</option>
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->naam }}" {{ request('tag') === $tag->naam ? 'selected' : '' }}>
                                {{ $tag->naam }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @if (request('tag'))
                    <a href="{{ route('home') }}" class="text-indigo-600 hover:underline">Reset filter</a>
                @endif
            </form>

            <!-- Stage cards -->
            @forelse($stages as $stage)
                <div class="bg-white rounded-3xl shadow-lg p-5 grid grid-cols-1 md:grid-cols-3 gap-5 items-center hover:shadow-xl transition">

                    <div class="md:col-span-2 space-y-1">
                        <h3 class="text-2xl font-bold text-indigo-800">{{ $stage->titel }}</h3>
                        <p class="text-gray-600">{{ $stage->beschrijving ?? 'Geen beschrijving beschikbaar' }}</p>
                        <div class="flex flex-wrap gap-3 text-gray-700 mt-1">
                            <div><span class="font-medium">Bedrijf:</span> {{ $stage->company->naam ?? 'Onbekend' }}</div>
                            <div><span class="font-medium">Begeleider:</span> {{ $stage->teacher->naam ?? 'Nog niet gekoppeld' }}</div>
                            @if ($stage->tags && count($stage->tags))
                                <div><span class="font-medium">Tags:</span>
                                    {{ implode(', ', $stage->tags->pluck('naam')->toArray()) }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="text-center md:text-right">
                        @auth
                            @if($user->role === 'student')
                                @if($mijnKeuze && $mijnKeuze->id === $stage->id)
                                    <span class="px-5 py-2 rounded-xl font-semibold 
                                        @if($stage->status === 'in_behandeling') bg-yellow-200 text-yellow-800
                                        @elseif($stage->status === 'goedgekeurd') bg-green-200 text-green-800
                                        @elseif($stage->status === 'afgekeurd') bg-red-200 text-red-800 @endif">
                                        {{ ucfirst(str_replace('_',' ', $stage->status)) }}
                                    </span>
                                @elseif($stage->status === 'vrij')
                                    <form action="{{ route('stages.choose', $stage->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-green-500 text-white font-semibold py-2 px-5 rounded-xl hover:bg-green-600 transition">
                                            Kies deze stage
                                        </button>
                                    </form>
                                @else
                                    <span class="px-5 py-2 rounded-xl font-semibold bg-gray-200 text-gray-700">
                                        Bezet
                                    </span>
                                @endif
                            @else
                                <span class="px-5 py-2 rounded-xl font-semibold 
                                    @if($stage->status === 'vrij') bg-blue-200 text-blue-800
                                    @elseif($stage->status === 'in_behandeling') bg-yellow-200 text-yellow-800
                                    @elseif($stage->status === 'goedgekeurd') bg-green-200 text-green-800
                                    @elseif($stage->status === 'afgekeurd') bg-red-200 text-red-800 @endif">
                                    {{ ucfirst(str_replace('_',' ', $stage->status)) }}
                                </span>
                            @endif
                        @else
                            <span class="px-5 py-2 rounded-xl font-semibold bg-blue-200 text-blue-800">Login om te kiezen</span>
                        @endauth
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500">Er zijn momenteel geen stages beschikbaar.</p>
            @endforelse
        </div>
    </main>

    <!-- Mijn Keuze -->
    @auth
        @if ($user->role === 'student' && $mijnKeuze)
            <section class="py-12 bg-white border-t border-gray-200">
                <div class="max-w-7xl mx-auto px-6">
                    <h2 class="text-3xl font-extrabold text-indigo-800 mb-6 border-b-2 border-indigo-300 pb-2">Mijn Keuze (BPV)</h2>
                    <div class="rounded-2xl shadow-md p-6 space-y-4
                        @if ($mijnKeuze->status === 'goedgekeurd') bg-green-50 border border-green-200
                        @elseif($mijnKeuze->status === 'afgekeurd') bg-red-50 border border-red-200
                        @else bg-yellow-50 border border-yellow-200 @endif">

                        <div class="flex justify-between items-start">
                            <h3 class="text-2xl font-bold
                                @if ($mijnKeuze->status === 'goedgekeurd') text-green-700
                                @elseif($mijnKeuze->status === 'afgekeurd') text-red-700
                                @else text-yellow-700 @endif">
                                {{ $mijnKeuze->titel }}
                            </h3>
                            <span class="px-4 py-2 rounded-xl font-semibold
                                @if ($mijnKeuze->status === 'goedgekeurd') bg-green-200 text-green-800
                                @elseif ($mijnKeuze->status === 'afgekeurd') bg-red-200 text-red-800
                                @else bg-yellow-200 text-yellow-800 @endif">
                                @if ($mijnKeuze->status === 'goedgekeurd') ✅ Goedgekeurd
                                @elseif ($mijnKeuze->status === 'afgekeurd') ❌ Afgewezen
                                @else ⏳ In behandeling @endif
                            </span>
                        </div>

                        <p class="text-gray-600">{{ $mijnKeuze->beschrijving ?? 'Geen beschrijving beschikbaar' }}</p>
                        <div class="flex flex-wrap gap-4 text-gray-700">
                            <div><span class="font-medium">Bedrijf:</span> {{ $mijnKeuze->company->naam ?? 'Onbekend' }}</div>
                            <div><span class="font-medium">Begeleider:</span> {{ $mijnKeuze->teacher->naam ?? 'Nog niet gekoppeld' }}</div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endauth

    <!-- Footer -->
    <footer class="bg-indigo-600 text-white mt-auto">
        <div class="max-w-7xl mx-auto py-6 px-6 text-center text-sm">
            &copy; {{ date('Y') }} StageZoeker. Alle rechten voorbehouden.
        </div>
    </footer>

</body>

</html>
