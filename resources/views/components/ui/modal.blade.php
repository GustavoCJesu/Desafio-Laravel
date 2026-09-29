@props(['id', 'title', 'subtitle' => null, 'icon' => null, 'size' => 'max-w-lg'])

<div id="{{ $id }}" class="modal-backdrop hidden" onclick="if (event.target === this) toggleModal('{{ $id }}')">
    <div class="modal-panel {{ $size }}">
        <div class="flex items-start gap-3 border-b border-slate-100 px-6 py-5">
            @if ($icon)
                <div class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-brand-100 text-brand-700">
                    <i data-lucide="{{ $icon }}" class="size-5"></i>
                </div>
            @endif
            <div class="flex-1">
                <h2 class="text-base font-semibold text-slate-900">{{ $title }}</h2>
                @if ($subtitle)
                    <p class="text-sm text-slate-500">{{ $subtitle }}</p>
                @endif
            </div>
            <button type="button" class="icon-btn -mr-2 -mt-1" aria-label="Fechar" onclick="toggleModal('{{ $id }}')">
                <i data-lucide="x"></i>
            </button>
        </div>

        {{ $slot }}
    </div>
</div>
