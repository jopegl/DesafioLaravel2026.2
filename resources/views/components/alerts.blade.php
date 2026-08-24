@if (session('success'))
<div class="mb-4 rounded-lg bg-emerald-500/10 border border-emerald-500/40 text-emerald-300 text-sm px-4 py-3">
    {{ session('success') }}
</div>
@endif

@if (session('error'))
<div class="mb-4 rounded-lg bg-red-500/10 border border-red-500/40 text-red-300 text-sm px-4 py-3">
    {{ session('error') }}
</div>
@endif

@if ($errors->any())
<div class="mb-4 rounded-lg bg-red-500/10 border border-red-500/40 text-red-300 text-sm px-4 py-3">
    <ul class="list-disc list-inside">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif