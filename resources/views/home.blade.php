@php
    use App\Models\Stage;
@endphp

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>StageZoeker - Beschikbare Stages</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-b from-indigo-50 via-white to-gray-50 min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-indigo-600 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <img src="{{ asset('build/assets/stagebeheer.png') }}" alt="StageZoeker Logo" class="h-12 w-auto rounded-md bg-white p-1">
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

    <!-- Notificaties -->
    <div class="max-w-7xl mx-auto px-6 mt-6 space-y-4">
        @if(session('success'))
            <div class="text-green-800 bg-green-100 p-4 rounded-xl shadow text-center">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="text-red-800 bg-red-100 p-4 rounded-xl shadow text-center">
                {{ session('error') }}
            </div>
        @endif

        {{-- Dynamische notificatie voor ingelogde student --}}
        @auth
            @if(auth()->user()->role === 'student' && isset($mijnKeuze) && $mijnKeuze)
                @php
                    $status = $mijnKeuze->status;
                    $message = '';
                    $bgClass = '';
                    $textClass = '';
                    switch ($status) {
                        case 'in_behandeling':
                            $message = "📢 Je hebt een stage gekozen: '{$mijnKeuze->titel}'. Deze wordt beoordeeld door de beheerder.";
                            $bgClass = 'bg-yellow-100';
                            $textClass = 'text-yellow-800';
                            break;
                        case 'goedgekeurd':
                            $message = "🎉 Je stage '{$mijnKeuze->titel}' is goedgekeurd. Begeleider: " . ($mijnKeuze->teacher?->naam ?? 'Nog niet toegewezen') . ".";
                            $bgClass = 'bg-green-100';
                            $textClass = 'text-green-800';
                            break;
                        case 'afgekeurd':
                            $message = "❌ Je stage '{$mijnKeuze->titel}' is afgekeurd. Kies een nieuwe stage.";
                            $bgClass = 'bg-red-100';
                            $textClass = 'text-red-800';
                            break;
                    }
                @endphp

                <div class="p-4 rounded-xl shadow text-center font-semibold {{ $bgClass }} {{ $textClass }}">
                    {{ $message }}
                </div>
            @endif
        @endauth
    </div>

    <!-- Main -->
    <main class="flex-1 py-10 px-6">
        <div class="max-w-7xl mx-auto space-y-8">

            {{-- Beschikbare stages --}}
            <section>
                <h3 class="text-2xl font-bold text-indigo-800 mb-4">Beschikbare stages</h3>
                <div class="space-y-6">
                    @forelse($stages as $stage)
                        @php
                            $isMijnStage = isset($mijnKeuze) && $mijnKeuze && $mijnKeuze->id === $stage->id;
                        @endphp

                        <div class="bg-white rounded-3xl shadow-lg p-6 grid grid-cols-1 md:grid-cols-3 gap-6 items-center hover:shadow-xl transition">
                            <div class="md:col-span-2">
                                <h4 class="text-xl font-semibold text-indigo-800">{{ $stage->titel }}</h4>
                                <p class="text-gray-600 mt-1">{{ $stage->beschrijving ?? 'Geen beschrijving beschikbaar' }}</p>

                                <div class="flex flex-wrap gap-4 text-gray-700 mt-3">
                                    <div><span class="font-medium">Bedrijf:</span> {{ $stage->company->naam ?? 'Onbekend' }}</div>
                                    <div><span class="font-medium">Begeleider:</span> {{ $stage->teacher->naam ?? 'Nog niet gekoppeld' }}</div>
                                    @if($stage->tags && $stage->tags->count())
                                        <div><span class="font-medium">Tags:</span> {{ $stage->tags->pluck('naam')->join(', ') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="text-center md:text-right">
                                @auth
                                    @if(auth()->user()->role === 'student')
                                        @if($stage->status === 'vrij')
                                            <form action="{{ route('stages.choose', $stage->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="bg-green-500 text-white px-5 py-2 rounded-xl font-semibold hover:bg-green-600 transition">
                                                    Kies deze stage
                                                </button>
                                            </form>
                                        @elseif($isMijnStage)
                                            <span class="px-5 py-2 rounded-xl font-semibold
                                                @if($stage->status === 'in_behandeling') bg-yellow-200 text-yellow-800
                                                @elseif($stage->status === 'goedgekeurd') bg-green-200 text-green-800
                                                @elseif($stage->status === 'afgekeurd') bg-red-200 text-red-800 @endif">
                                                {{ ucfirst(str_replace('_',' ', $stage->status)) }}
                                            </span>
                                        @else
                                            <span class="px-5 py-2 rounded-xl font-semibold bg-gray-100 text-gray-500">Niet beschikbaar</span>
                                        @endif
                                    @elseif(auth()->user()->role === 'teacher')
                                        @php
                                            $studentCount = $teacherStudents ? $teacherStudents->where('stage_id', $stage->id)->count() : 0;
                                        @endphp
                                        <span class="px-5 py-2 rounded-xl font-semibold
                                            @if($stage->status === 'vrij') bg-blue-200 text-blue-800
                                            @elseif($stage->status === 'in_behandeling') bg-yellow-200 text-yellow-800
                                            @elseif($stage->status === 'goedgekeurd') bg-green-200 text-green-800
                                            @elseif($stage->status === 'afgekeurd') bg-red-200 text-red-800 @endif">
                                            {{ ucfirst(str_replace('_',' ', $stage->status)) }}
                                            @if($studentCount > 0)
                                                | {{ $studentCount }} student(en)
                                            @endif
                                        </span>
                                    @elseif(auth()->user()->role === 'admin')
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
            </section>

            {{-- Mijn keuze voor studenten --}}
            @auth
                @if(auth()->user()->role === 'student' && isset($mijnKeuze) && $mijnKeuze)
                    <section class="pt-6">
                        <h3 class="text-2xl font-bold text-indigo-800 mb-3">Mijn keuze (BPV)</h3>
                        <div class="bg-white p-6 rounded-2xl shadow">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="text-xl font-semibold">{{ $mijnKeuze->titel }}</h4>
                                    <p class="text-sm text-gray-600">{{ $mijnKeuze->company->naam ?? 'Onbekend bedrijf' }}</p>
                                </div>
                                <div>
                                    <span class="px-4 py-2 rounded-xl font-semibold
                                        @if($mijnKeuze->status === 'goedgekeurd') bg-green-200 text-green-800
                                        @elseif($mijnKeuze->status === 'afgekeurd') bg-red-200 text-red-800
                                        @else bg-yellow-200 text-yellow-800 @endif">
                                        @if($mijnKeuze->status === 'goedgekeurd') ✅ Goedgekeurd
                                        @elseif($mijnKeuze->status === 'afgekeurd') ❌ Afgewezen
                                        @else ⏳ In behandeling @endif
                                    </span>
                                </div>
                            </div>
                            <div class="mt-4 text-gray-700">
                                <p>{{ $mijnKeuze->beschrijving ?? 'Geen beschrijving beschikbaar' }}</p>
                                <div class="mt-3 text-sm text-gray-600">
                                    <div><strong>Begeleider:</strong> {{ $mijnKeuze->teacher->naam ?? 'Nog niet toegewezen' }}</div>
                                </div>
                            </div>
                        </div>
                    </section>
                @endif
            @endauth

        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-indigo-600 text-white mt-auto">
        <div class="max-w-7xl mx-auto py-6 px-6 text-center text-sm">
            &copy; {{ date('Y') }} StageZoeker. Alle rechten voorbehouden.
        </div>
    </footer>
</body>
</html>
