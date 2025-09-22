<div class="grid grid-cols-3 gap-6 p-6">
    <div class="bg-gradient-to-r from-indigo-500 to-purple-500 rounded-lg shadow-lg p-6 text-white">
        <h2 class="text-lg font-bold">Open Stages</h2>
        <p class="text-3xl">{{ \App\Models\Stage::where('status','vrij')->count() }}</p>
    </div>
    <div class="bg-green-500 rounded-lg shadow-lg p-6 text-white">
        <h2 class="text-lg font-bold">Closed Stages</h2>
        <p class="text-3xl">{{ \App\Models\Stage::where('status','op slot')->count() }}</p>
    </div>
    <div class="bg-yellow-500 rounded-lg shadow-lg p-6 text-white">
        <h2 class="text-lg font-bold">Total Tags</h2>
        <p class="text-3xl">{{ \App\Models\Tag::count() }}</p>
    </div>
</div>
