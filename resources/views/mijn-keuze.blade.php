<!DOCTYPE html>
<html lang="nl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Stagebeheer - Mijn keuze</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-b from-indigo-50 via-white to-gray-50 min-h-screen flex flex-col">

  <!-- Header -->
  <header class="bg-indigo-600 text-white">
    <div class="max-w-7xl mx-auto px-6 py-6 flex justify-between items-center">
      <h1 class="text-3xl font-bold tracking-tight">Stagebeheer</h1>
      <nav class="space-x-6">
        <a href="{{ route('home') }}" class="hover:underline font-medium">Home</a>
        <a href="/admin" class="hover:underline font-medium">Dashboard</a>
        <!-- ✅ Fix: correcte route zonder parameter -->
        <a href="{{ route('mijn-keuze') }}" class="hover:underline font-medium">Mijn keuze</a>
      </nav>
    </div>
  </header>

  <!-- Content -->
  <main class="flex-1 py-12 px-6">
    <div class="max-w-3xl mx-auto bg-white rounded-3xl shadow-lg p-8">
      <h2 class="text-3xl font-extrabold text-indigo-800 mb-6">Mijn gekozen stage</h2>

      @if($student->stage)
      <div class="space-y-4">
        <div>
          <span class="font-semibold">Stage:</span>
          <p class="text-gray-700">{{ $student->stage->titel }}</p>
        </div>
        <div>
          <span class="font-semibold">Beschrijving:</span>
          <p class="text-gray-600">{{ $student->stage->beschrijving }}</p>
        </div>
        <div>
          <span class="font-semibold">Bedrijf:</span>
          <p class="text-gray-700">{{ $student->stage->company?->naam ?? '-' }}</p>
        </div>
        <div>
          <span class="font-semibold">Docent:</span>
          <p class="text-gray-700">{{ $student->stage->teacher?->naam ?? 'Nog niet gekoppeld' }}</p>
        </div>
        <div>
          <span class="font-semibold">Status:</span>
          <p class="text-gray-700">{{ ucfirst($student->stage->status) }}</p>
        </div>
      </div>
      @else
      <p class="text-gray-500">Je hebt nog geen stage gekozen.</p>
      @endif
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
