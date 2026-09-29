@props(['position', 'grouped'])

@php
    $modalId = 'editPositionModal-'.$position->id;
@endphp

<x-ui.modal :id="$modalId" title="Editar cargo" :subtitle="$position->title" icon="shield" size="max-w-2xl">
    <form action="{{ route('position.update', $position->id) }}" method="POST" id="editPositionForm-{{ $position->id }}">
        @csrf
        @method('PUT')
        <div class="flex flex-col gap-4 px-6 py-5">
            <div>
                <label class="form-label" for="title_{{ $position->id }}">Título</label>
                <input id="title_{{ $position->id }}" name="title" value="{{ $position->title }}" class="form-input" type="text" />
            </div>
            <div>
                <p class="form-label">Permissões</p>
                <x-ui.permission-grid :grouped="$grouped" :selected="$position->rolePermissions->pluck('permission_id')->all()" />
            </div>
        </div>
        <div class="flex justify-end gap-2 border-t border-slate-100 bg-slate-50 px-6 py-4">
            <button type="button" class="btn btn-secondary" onclick="toggleModal('{{ $modalId }}')">Cancelar</button>
            <button type="submit" class="btn btn-primary"><i data-lucide="save"></i>Salvar</button>
        </div>
    </form>
</x-ui.modal>
