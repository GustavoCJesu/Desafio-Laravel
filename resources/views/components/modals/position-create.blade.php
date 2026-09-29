@props(['grouped'])

<x-ui.modal id="positionModal" title="Novo cargo" subtitle="Defina o nome e as permissões de acesso." icon="shield-plus" size="max-w-2xl">
    <form action="{{ route('position.create') }}" method="POST" id="positionForm">
        @csrf
        <div class="flex flex-col gap-4 px-6 py-5">
            <div>
                <label class="form-label" for="position_title">Título</label>
                <input id="position_title" name="title" required placeholder="Ex.: Supervisor" class="form-input" type="text" />
            </div>
            <div>
                <p class="form-label">Permissões</p>
                <x-ui.permission-grid :grouped="$grouped" />
            </div>
        </div>
        <div class="flex justify-end gap-2 border-t border-slate-100 bg-slate-50 px-6 py-4">
            <button type="button" class="btn btn-secondary" onclick="toggleModal('positionModal')">Cancelar</button>
            <button type="submit" class="btn btn-primary"><i data-lucide="check"></i>Criar cargo</button>
        </div>
    </form>
</x-ui.modal>
