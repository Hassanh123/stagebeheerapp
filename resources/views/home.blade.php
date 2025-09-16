<!DOCTYPE html>
<html lang="nl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Stagebeheer - Beschikbare Stages</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-b from-indigo-50 via-white to-gray-50 min-h-screen flex flex-col">

  <!-- Header -->
  <header class="bg-indigo-600 text-white">
    <div class="max-w-7xl mx-auto px-6 py-6 flex justify-between items-center">
      <h1 class="text-3xl font-bold tracking-tight">Stagebeheer</h1>
      <nav class="space-x-6">
        <a href="{{ route('home') }}" class="hover:underline font-medium">Home</a>
        <a href="{{ route('dashboard') }}" class="hover:underline font-medium">Dashboard</a>
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
    @if(session('success'))
    <div class="mb-6 text-green-800 bg-green-100 p-4 rounded-xl shadow text-center">
      {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="mb-6 text-red-800 bg-red-100 p-4 rounded-xl shadow text-center">
      {{ session('error') }}
    </div>
    @endif
  </div>

  <!-- Stages List -->
  <main class="flex-1 py-10 px-6">
    <div class="max-w-7xl mx-auto space-y-6">
      @forelse($stages as $stage)
      <div class="bg-white rounded-3xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-1 hover:scale-102 p-6 flex flex-col md:flex-row justify-between items-start gap-6">
        
        <!-- Stage Info -->
        <div class="flex-1">
          <h3 class="text-2xl font-bold text-indigo-800 mb-2">{{ $stage->titel }}</h3>
          <p class="text-gray-600 mb-4">{{ $stage->beschrijving }}</p>

          <div class="flex flex-col sm:flex-row sm:gap-6 text-gray-700">
            @if($stage->teacher)
            <div>
              <span class="font-medium">Begeleider:</span>
              <span class="text-sm">{{ $stage->teacher->naam }}</span>
            </div>
            @endif

            @if($stage->company)
            <div>
              <span class="font-medium">Bedrijf:</span>
              <span class="text-sm">{{ $stage->company->naam }}</span>
            </div>
            @endif
          </div>
        </div>

        <!-- Stage Status / Button -->
        <div class="mt-4 md:mt-0 flex-shrink-0 w-full md:w-auto">
          @if($stage->status === 'vrij')
          <form method="POST" action="{{ route('stages.choose', $stage) }}">
            @csrf
            <button type="submit" class="w-full md:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-xl transition">
              Meld je aan voor deze stage
            </button>
          </form>
          @else
          <div class="w-full md:w-auto text-center bg-gray-300 text-gray-700 font-semibold py-2 px-6 rounded-xl">
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

  <!-- Footer -->
  <footer class="bg-indigo-600 text-white mt-auto">
    <div class="max-w-7xl mx-auto py-6 px-6 text-center text-sm">
      &copy; {{ date('Y') }} Stagebeheer. Alle rechten voorbehouden.
    </div>
  </footer>

</body>
</html>
