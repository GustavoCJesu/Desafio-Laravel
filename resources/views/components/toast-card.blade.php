@props(['type' => 'success', 'message' => '', 'duration' => 5000])

@php
    $styles = $type === 'success'
        ? ['bg-green-100 border-green-300 text-green-800', 'check-circle']
        : ['bg-red-100 border-red-300 text-red-800', 'alert-circle'];
@endphp

<div class="toast pointer-events-auto flex items-center gap-3 rounded-lg border shadow-lg px-5 py-3 min-w-72 max-w-md {{ $styles[0] }}"
    data-duration="{{ $duration }}" role="alert">
    <i data-lucide="{{ $styles[1] }}" class="w-5 h-5 shrink-0"></i>
    <p class="flex-1 font-semibold">{{ $message }}</p>
    <button type="button" class="toast-close cursor-pointer hover:scale-110 transition shrink-0" aria-label="Fechar">
        <i data-lucide="x" class="w-4 h-4"></i>
    </button>
</div>
