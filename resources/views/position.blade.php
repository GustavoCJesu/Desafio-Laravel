<x-app-layout title="Cargos do sistema" subtitle="Funções de acesso e suas permissões" icon="briefcase">
    <x-slot:modals>
        <x-create-position-modal :grouped="$grouped" />
        @foreach ($positions as $position)
            <x-edit-position-modal :position="$position" :grouped="$grouped" />
        @endforeach
    </x-slot:modals>

    <x-slot:actions>
        <button type="button" onclick="toggleModal('positionModal')" class="btn btn-primary">
            <i data-lucide="plus"></i><span class="hidden sm:inline">Criar novo cargo</span>
        </button>
    </x-slot:actions>

    <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4">
        @foreach ($positions as $position)
            @php
                $permissionCount = $position->rolePermissions->count();
            @endphp
            <div class="card group flex flex-col transition hover:-translate-y-0.5 hover:shadow-elevated">
                <div class="flex items-start gap-3 p-5">
                    <div class="bg-gradient-primary flex size-11 shrink-0 items-center justify-center rounded-xl text-white shadow-sm">
                        <i data-lucide="shield" class="size-5"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="truncate font-semibold text-slate-900 uppercase">{{ $position->title }}</h3>
                        <p class="text-xs text-slate-500">Criado em {{ $position->created_at?->format('d/m/Y') }}</p>
                    </div>
                    <span class="badge {{ $position->status === 'Ativo' ? 'badge-success' : 'badge-neutral' }}">
                        {{ $position->status }}
                    </span>
                </div>

                <div class="px-5 pb-5">
                    <div class="flex items-center justify-between text-xs text-slate-500">
                        <span>Permissões</span>
                        <span class="font-semibold text-slate-700">{{ $permissionCount }}</span>
                    </div>
                    <div class="mt-2 h-1.5 overflow-hidden rounded-full bg-slate-100">
                        <div class="bg-gradient-primary h-full rounded-full"
                            style="width: {{ min(100, $permissionCount * 100 / max(1, $grouped->sum(fn ($group) => $group->count()))) }}%"></div>
                    </div>
                </div>

                <div class="mt-auto flex gap-2 border-t border-slate-100 px-5 py-3">
                    <button type="button" onclick="toggleModal('editPositionModal-{{ $position->id }}')"
                        class="btn btn-secondary btn-sm flex-1">
                        <i data-lucide="pencil"></i>Editar
                    </button>
                    <button type="button" class="btn btn-danger-soft btn-sm" title="Excluir">
                        <i data-lucide="trash-2"></i>
                    </button>
                </div>
            </div>
        @endforeach

        <button type="button" onclick="toggleModal('positionModal')"
            class="flex min-h-48 flex-col items-center justify-center gap-2 rounded-xl border-2 border-dashed border-slate-300 text-slate-500 transition hover:border-accent-500 hover:bg-white hover:text-accent-600">
            <i data-lucide="plus-circle" class="size-8"></i>
            <span class="text-sm font-medium">Novo cargo</span>
        </button>
    </div>
</x-app-layout>
