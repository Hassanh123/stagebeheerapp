@php
use Illuminate\Support\Str;

$student = auth()->user()?->student;
$mijnKeuze = null;

if ($student && $student->stage_id) {
    $stage = \App\Models\Stage::with(['company', 'teacher', 'tags'])->find($student->stage_id);
    if ($stage && in_array($stage->status, ['in_behandeling', 'goedgekeurd', 'afgekeurd'])) {
        $mijnKeuze = $stage;
    }
}
@endphp

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

<!-- Hero -->
<section class="py-12 bg-indigo-50 border-b border-indigo-200">
    <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-4xl font-extrabold text-indigo-800 mb-4">Vind jouw perfecte stage!</h2>
        <p class="text-indigo-600 text-lg mb-6">
            Bekijk hieronder alle beschikbare stages en hun status. Om een stage te kiezen, moet je <strong>ingelogd</strong> zijn als student.
        </p>
        @guest
            <div class="space-x-4">
                <a href="{{ route('login') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-xl font-semibold shadow hover:bg-indigo-700">Inloggen</a>
                <a href="{{ route('register') }}" class="bg-white text-indigo-600 px-6 py-3 rounded-xl font-semibold border border-indigo-600 shadow hover:bg-indigo-50">Registreren</a>
            </div>
        @endguest
    </div>
</section>

<!-- Flash messages -->
<div class="max-w-7xl mx-auto px-6 mt-6">
    @if(session('success'))
        <div class="mb-6 text-green-800 bg-green-100 p-4 rounded-xl shadow text-center">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-6 text-red-800 bg-red-100 p-4 rounded-xl shadow text-center">{{ session('error') }}</div>
    @endif
</div>

<!-- Beschikbare Stages -->
<main class="flex-1 py-10 px-6">
    <div class="max-w-7xl mx-auto space-y-6">
        <h2 class="text-3xl font-extrabold text-indigo-800 mb-6 border-b-2 border-indigo-300 pb-2">Beschikbare Stages</h2>

        @forelse($stages as $stage)
            <div class="bg-white rounded-3xl shadow-lg p-6 grid grid-cols-1 md:grid-cols-3 gap-6 items-center hover:shadow-xl transition">

                <!-- Info links -->
                <div class="md:col-span-2 space-y-2">
                    <h3 class="text-2xl font-bold text-indigo-800">{{ $stage->titel }}</h3>
                    <p class="text-gray-600">{{ $stage->beschrijving ?? 'Geen beschrijving beschikbaar' }}</p>
                    <div class="flex flex-wrap gap-4 text-gray-700 mt-2">
                        <div><span class="font-medium">Bedrijf:</span> {{ $stage->company->naam ?? 'Onbekend' }}</div>
                        <div><span class="font-medium">Begeleider:</span> {{ $stage->teacher->naam ?? 'Nog niet gekoppeld' }}</div>
                        @if($stage->tags && count($stage->tags))
                            <div><span class="font-medium">Tags:</span> {{ implode(', ', $stage->tags->pluck('naam')->toArray()) }}</div>
                        @endif
                    </div>
                </div>

                <!-- Actie / status rechts -->
                <div class="text-center md:text-right">
                    @auth
                        @if(auth()->user()->role === 'student')
                            @if(!$mijnKeuze && $stage->status === 'vrij')
                                <form action="{{ route('stages.choose', $stage->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-green-200 text-green-800 font-semibold py-2 px-6 rounded-xl hover:bg-green-300 transition">
                                        Kies deze stage
                                    </button>
                                </form>
                            @else
                                <span class="px-6 py-2 rounded-xl font-semibold 
                                    @if($stage->status === 'vrij') bg-blue-200 text-blue-800 
                                    @elseif($stage->status === 'in_behandeling') bg-yellow-200 text-yellow-800 
                                    @elseif($stage->status === 'goedgekeurd') bg-green-200 text-green-800 
                                    @elseif($stage->status === 'afgekeurd') bg-red-200 text-red-800 @endif">
                                    {{ ucfirst(str_replace('_',' ', $stage->status)) }}
                                </span>
                            @endif
                        @else
                            <span class="px-6 py-2 rounded-xl font-semibold 
                                @if($stage->status === 'vrij') bg-blue-200 text-blue-800 
                                @elseif($stage->status === 'in_behandeling') bg-yellow-200 text-yellow-800 
                                @elseif($stage->status === 'goedgekeurd') bg-green-200 text-green-800 
                                @elseif($stage->status === 'afgekeurd') bg-red-200 text-red-800 @endif">
                                {{ ucfirst(str_replace('_',' ', $stage->status)) }}
                            </span>
                        @endif
                    @else
                        <span class="px-6 py-2 rounded-xl font-semibold 
                            @if($stage->status === 'vrij') bg-blue-200 text-blue-800 
                            @elseif($stage->status === 'in_behandeling') bg-yellow-200 text-yellow-800 
                            @elseif($stage->status === 'goedgekeurd') bg-green-200 text-green-800 
                            @elseif($stage->status === 'afgekeurd') bg-red-200 text-red-800 @endif">
                            {{ ucfirst(str_replace('_',' ', $stage->status)) }}
                        </span>
                        <p class="mt-1 text-sm text-gray-500">
                            @if($stage->status === 'vrij')
                                Login om deze stage te kiezen
                            @else
                                Stage is bezet
                            @endif
                        </p>
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
    @if(auth()->user()->role === 'student' && $mijnKeuze)
        <section class="py-12 bg-white border-t border-gray-200">
            <div class="max-w-7xl mx-auto px-6">
                <h2 class="text-3xl font-extrabold text-indigo-800 mb-6 border-b-2 border-indigo-300 pb-2">Mijn Keuze (BPV)</h2>
                <div class="bg-indigo-50 rounded-2xl shadow-md p-6 space-y-4">
                    <h3 class="text-2xl font-bold text-indigo-700">{{ $mijnKeuze->titel }}</h3>
                    <p class="text-gray-600">{{ $mijnKeuze->beschrijving ?? 'Geen beschrijving beschikbaar' }}</p>
                    <div class="flex flex-wrap gap-4 text-gray-700">
                        <div><span class="font-medium">Bedrijf:</span> {{ $mijnKeuze->company->naam ?? 'Onbekend' }}</div>
                        <div><span class="font-medium">Begeleider:</span> {{ $mijnKeuze->teacher->naam ?? 'Nog niet gekoppeld' }}</div>
                    </div>
                    <div class="text-center mt-4">
                        @if($mijnKeuze->status === 'in_behandeling')
                            <span class="bg-yellow-200 text-yellow-800 px-4 py-2 rounded-xl font-semibold">In behandeling</span>
                        @elseif($mijnKeuze->status === 'goedgekeurd')
                            <span class="bg-green-200 text-green-800 px-4 py-2 rounded-xl font-semibold">Goedgekeurd</span>
                        @elseif($mijnKeuze->status === 'afgekeurd')
                            <span class="bg-red-200 text-red-800 px-4 py-2 rounded-xl font-semibold">Afgewezen</span>
                        @endif
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
