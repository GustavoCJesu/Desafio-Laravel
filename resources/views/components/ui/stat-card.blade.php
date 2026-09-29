@props(['label', 'value', 'icon', 'tone' => 'brand', 'hint' => null])

@php
    $tones = [
        'brand' => 'bg-brand-100 text-brand-700',
        'success' => 'bg-emerald-100 text-emerald-700',
        'danger' => 'bg-red-100 text-red-700',
        'warning' => 'bg-amber-100 text-amber-700',
        'accent' => 'bg-indigo-100 text-accent-600',
    ];
@endphp

<div class="card flex items-center gap-4 p-5">
    <div class="flex size-12 shrink-0 items-center justify-center rounded-xl {{ $tones[$tone] ?? $tones['brand'] }}">
        <i data-lucide="{{ $icon }}" class="size-6"></i>
    </div>
    <div class="min-w-0">
        <p class="truncate text-sm text-slate-500">{{ $label }}</p>
        <p class="text-2xl font-bold text-slate-900">{{ $value }}</p>
        @if ($hint)
            <p class="truncate text-xs text-slate-400">{{ $hint }}</p>
        @endif
    </div>
</div>
