@props(['title'])

<div class="rounded-xl bg-white p-10 shadow-sm">
    <p class="text-sm font-semibold uppercase tracking-[0.3em] text-emerald-600">Welcome</p>
    <h1 class="mt-4 text-4xl font-bold text-gray-900">{{ strtoupper($title) }}</h1>
</div>
