@props(['categories'])

<x-ui.modal id="editepimodal" title="Editar EPI" subtitle="Atualize os dados do equipamento." icon="pencil">
    <form data-action="{{ route('epi.update', ['epi' => '__ID__']) }}" id="editEpi"
        action="{{ route('epi.update', ['epi' => '__ID__']) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="grid gap-4 px-6 py-5 sm:grid-cols-2">
            <div>
                <label class="form-label" for="edit_ca">CA</label>
                <input id="edit_ca" name="ca" class="form-input" type="text" />
            </div>
            <div>
                <label class="form-label" for="edit_status">Status</label>
                <select id="edit_status" name="status" class="form-input">
                    <option>Ativo</option>
                    <option>Inativo</option>
                </select>
            </div>
            <div class="sm:col-span-2">
                <label class="form-label" for="edit_name">Nome</label>
                <input id="edit_name" name="name" class="form-input" type="text" />
            </div>
            <div class="sm:col-span-2">
                <label class="form-label" for="edit_category">Categoria</label>
                <select id="edit_category" name="category_id" class="form-input">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex justify-end gap-2 border-t border-slate-100 bg-slate-50 px-6 py-4">
            <button type="button" class="btn btn-secondary" onclick="toggleModal('editepimodal')">Cancelar</button>
            <button type="submit" class="btn btn-primary"><i data-lucide="save"></i>Salvar</button>
        </div>
    </form>
</x-ui.modal>
