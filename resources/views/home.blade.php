@php
use App\Models\Tag;
$user = $user ?? auth()->user();
$isTeacher = $user && $user->role === 'teacher';
$isStudent = $user && $user->role === 'student';
@endphp
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>StageZoeker</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                    <form action="{{ route('logout') }}" method="POST" class="inline">@csrf
                        <button class="hover:underline hover:text-gray-200 font-medium transition">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:underline hover:text-gray-200 font-medium transition">Inloggen</a>
                    <a href="{{ route('register') }}" class="hover:underline hover:text-gray-200 font-medium transition">Registreren</a>
                @endauth
            </nav>
        </div>
    </header>

    <!-- Flash berichten -->
    <div class="max-w-7xl mx-auto px-6 mt-6 space-y-4">
        @foreach(['success', 'error', 'warning', 'info'] as $msg)
            @if(session($msg))
                <div class="p-4 rounded-xl shadow text-center
                    @if($msg === 'success') bg-green-100 text-green-800
                    @elseif($msg === 'error') bg-red-100 text-red-800
                    @elseif($msg === 'warning') bg-yellow-100 text-yellow-800
                    @elseif($msg === 'info') bg-blue-100 text-blue-800
                    @endif
                ">
                    {{ session($msg) }}
                </div>
            @endif
        @endforeach
    </div>

    <!-- Main -->
    <main class="flex-1 py-10 px-6">
        <div class="max-w-7xl mx-auto space-y-10">

            {{-- Docentgedeelte --}}
            @if ($isTeacher)
                <section>
                    <h3 class="text-3xl font-bold text-indigo-800 mb-4">Mijn studenten</h3>
                    @if ($teacherStudents->count())
                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($teacherStudents as $student)
                                <div class="bg-white border rounded-2xl p-5 shadow hover:shadow-lg transition">
                                    <h4 class="font-semibold text-lg text-gray-800">{{ $student->user->name ?? 'Onbekende student' }}</h4>
                                    <p class="text-sm text-gray-600">Email: {{ $student->user->email ?? '-' }}</p>
                                    <p class="text-sm text-gray-600">Studentnr: {{ $student->student_number ?? '-' }}</p>
                                    @if ($student->stage)
                                        <div class="mt-3 bg-indigo-50 p-3 rounded-lg">
                                            <p class="font-medium text-indigo-700 text-sm">Huidige stage:</p>
                                            <p class="text-sm text-gray-700">{{ $student->stage->titel }}</p>
                                            <p class="text-xs text-gray-500 italic">{{ ucfirst(str_replace('_', ' ', $student->stage->status)) }}</p>
                                        </div>
                                    @else
                                        <p class="text-gray-400 italic mt-2">Nog geen stage gekozen</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">Er zijn nog geen studenten gekoppeld aan jou.</p>
                    @endif
                </section>

                <section>
                    <h3 class="text-3xl font-bold text-indigo-800 mb-4 mt-10">Mijn stages</h3>
                    @if ($teacherStages->count())
                        <div class="space-y-6">
                            @foreach ($teacherStages as $stage)
                                <div class="bg-white rounded-3xl shadow p-6 hover:shadow-lg transition">
                                    <h4 class="text-xl font-semibold text-indigo-800">{{ $stage->titel }}</h4>
                                    <p class="text-gray-600 mt-2">{{ $stage->beschrijving ?? 'Geen beschrijving beschikbaar' }}</p>
                                    <div class="mt-4 flex flex-wrap gap-3 text-sm text-gray-700">
                                        <span><strong>Bedrijf:</strong> {{ $stage->company->naam ?? 'Onbekend' }}</span>
                                        <span><strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $stage->status)) }}</span>
                                        @if ($stage->tags->count())
                                            <span><strong>Tags:</strong> {{ $stage->tags->pluck('naam')->join(', ') }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">Je hebt nog geen stages toegewezen.</p>
                    @endif
                </section>
            @endif

            {{-- Beschikbare stages --}}
            <section>
                <h3 class="text-3xl font-bold text-indigo-800 mb-4">Beschikbare stages</h3>

                {{-- Filter --}}
                <form method="GET" class="mb-6">
                    <div class="flex flex-wrap gap-3 items-center">
                        <label class="font-medium text-gray-700">Filter op tag:</label>
                        <select name="tag" onchange="this.form.submit()" class="border rounded-lg px-3 py-2">
                            <option value="">Alle tags</option>
                            @foreach (Tag::all() as $tag)
                                <option value="{{ $tag->id }}" {{ request('tag') == $tag->id ? 'selected' : '' }}>
                                    {{ $tag->naam }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>

                <div class="space-y-6">
                    @forelse($stages as $stage)
                        @if (!request('tag') || ($stage->tags && $stage->tags->pluck('id')->contains(request('tag'))))
                            <div class="bg-white rounded-3xl shadow-lg p-6 grid grid-cols-1 md:grid-cols-3 gap-6 items-center hover:shadow-xl transition">
                                <div class="md:col-span-2">
                                    <h4 class="text-xl font-semibold text-indigo-800">{{ $stage->titel }}</h4>
                                    <p class="text-gray-600 mt-1">{{ $stage->beschrijving ?? 'Geen beschrijving beschikbaar' }}</p>
                                    <div class="flex flex-wrap gap-4 text-gray-700 mt-3">
                                        <div><span class="font-medium">Bedrijf:</span> {{ $stage->company->naam ?? 'Onbekend' }}</div>
                                        <div><span class="font-medium">Begeleider:</span> {{ $stage->teacher->naam ?? 'Nog niet gekoppeld' }}</div>
                                        @if ($stage->tags && $stage->tags->count())
                                            <div><span class="font-medium">Tags:</span> {{ $stage->tags->pluck('naam')->join(', ') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="text-center md:text-right">
                                    @auth
                                        @if ($isStudent)
                                            @php
                                                $isMijnStage = isset($mijnKeuze) && $mijnKeuze && $mijnKeuze->id === $stage->id;
                                            @endphp

                                            @if ($stage->status === 'vrij')
                                                <form action="{{ route('stages.choose', $stage->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="bg-green-500 text-white px-5 py-2 rounded-xl font-semibold hover:bg-green-600 transition">
                                                        Kies deze stage
                                                    </button>
                                                </form>
                                            @elseif ($isMijnStage)
                                                <span class="px-5 py-2 rounded-xl font-semibold
                                                    @if ($mijnKeuze->status === 'goedgekeurd') bg-green-200 text-green-800
                                                    @elseif ($mijnKeuze->status === 'afgekeurd') bg-red-200 text-red-800
                                                    @else bg-yellow-200 text-yellow-800 @endif">
                                                    {{ ucfirst(str_replace('_', ' ', $mijnKeuze->status)) }}
                                                </span>
                                            @else
                                                @if (!in_array($stage->status, ['in_behandeling','goedgekeurd']))
                                                    <form action="{{ route('stages.choose', $stage->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit"
                                                            class="bg-green-500 text-white px-5 py-2 rounded-xl font-semibold hover:bg-green-600 transition">
                                                            Kies deze stage
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="px-5 py-2 rounded-xl font-semibold bg-gray-100 text-gray-500">Niet beschikbaar</span>
                                                @endif
                                            @endif
                                        @else
                                            <span class="px-5 py-2 rounded-xl font-semibold bg-blue-200 text-blue-800">Alleen studenten kiezen stages</span>
                                        @endif
                                    @else
                                        <span class="px-5 py-2 rounded-xl font-semibold bg-blue-200 text-blue-800">Login om te kiezen</span>
                                    @endauth
                                </div>
                            </div>
                        @endif
                    @empty
                        <p class="text-center text-gray-500">Er zijn momenteel geen stages beschikbaar.</p>
                    @endforelse
                </div>
            </section>

            {{-- Mijn keuze --}}
            @if ($isStudent && isset($mijnKeuze) && in_array($mijnKeuze->status, ['in_behandeling','goedgekeurd','afgekeurd']))
                <section class="pt-6">
                    <h3 class="text-3xl font-bold text-indigo-800 mb-3">Mijn keuze</h3>
                    <div class="bg-white p-6 rounded-2xl shadow">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="text-xl font-semibold">{{ $mijnKeuze->titel }}</h4>
                                <p class="text-sm text-gray-600">{{ $mijnKeuze->company->naam ?? 'Onbekend bedrijf' }}</p>
                            </div>
                            <div>
                                @php
                                    $statusClass = match($mijnKeuze->status) {
                                        'goedgekeurd' => 'bg-green-200 text-green-800',
                                        'afgekeurd' => 'bg-red-200 text-red-800',
                                        'in_behandeling' => 'bg-yellow-200 text-yellow-800',
                                        default => 'bg-gray-200 text-gray-700',
                                    };
                                @endphp
                                <span class="px-4 py-2 rounded-xl font-semibold {{ $statusClass }}">
                                    {{ ucfirst(str_replace('_', ' ', $mijnKeuze->status)) }}
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
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-indigo-600 text-white mt-auto">
        <div class="max-w-7xl mx-auto py-6 px-6 text-center text-sm">&copy; {{ date('Y') }} StageZoeker. Alle rechten voorbehouden.</div>
    </footer>
</body>
</html>
