@props(['title' => null, 'subtitle' => null, 'icon' => null])

<x-layout :title="$title">
    {{ $modals ?? '' }}

    <div class="flex h-screen overflow-hidden">
        <x-sidebar-menu />

        {{-- Fundo escuro do menu no mobile --}}
        <div id="sidebar-overlay" class="fixed inset-0 z-30 hidden bg-slate-900/50 lg:hidden"
            onclick="toggleModal('sidebar'); toggleModal('sidebar-overlay')"></div>

        <div class="flex min-w-0 flex-1 flex-col">
            <header class="flex items-center gap-4 border-b border-slate-200 bg-white/80 px-4 py-4 backdrop-blur sm:px-8">
                <button type="button" class="icon-btn lg:hidden" aria-label="Abrir menu"
                    onclick="toggleModal('sidebar'); toggleModal('sidebar-overlay')">
                    <i data-lucide="menu"></i>
                </button>

                <div class="flex min-w-0 flex-1 items-center gap-3">
                    @if ($icon)
                        <div class="hidden size-10 shrink-0 items-center justify-center rounded-xl bg-brand-100 text-brand-700 sm:flex">
                            <i data-lucide="{{ $icon }}" class="size-5"></i>
                        </div>
                    @endif
                    <div class="min-w-0">
                        <h1 class="truncate text-lg font-bold text-slate-900 sm:text-xl">{{ $title }}</h1>
                        @if ($subtitle)
                            <p class="truncate text-sm text-slate-500">{{ $subtitle }}</p>
                        @endif
                    </div>
                </div>

                @isset($actions)
                    <div class="flex shrink-0 items-center gap-2">
                        {{ $actions }}
                    </div>
                @endisset
            </header>

            <main {{ $attributes->merge(['class' => 'flex-1 overflow-y-auto p-4 sm:p-8']) }}>
                {{ $slot }}
            </main>
        </div>
    </div>
</x-layout>
