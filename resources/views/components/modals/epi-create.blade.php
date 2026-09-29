@props(['categories'])

<x-ui.modal id="epimodal" title="Novo EPI" subtitle="Cadastre um equipamento pelo número do CA." icon="hard-hat">
    <form action="{{ route('epi.create') }}" method="POST" id="epiform">
        @csrf
        <div class="grid gap-4 px-6 py-5 sm:grid-cols-2">
            <div>
                <label class="form-label" for="ca">CA</label>
                <input id="ca" name="ca" required placeholder="12345" class="form-input" type="text" />
            </div>
            <div>
                <label class="form-label" for="status">Status</label>
                <select id="status" name="status" class="form-input">
                    <option>Ativo</option>
                    <option>Inativo</option>
                </select>
            </div>
            <div class="sm:col-span-2">
                <label class="form-label" for="name">Nome</label>
                <input id="name" name="name" required placeholder="Capacete de segurança" class="form-input" type="text" />
            </div>
            <div class="sm:col-span-2">
                <label class="form-label" for="category">Categoria</label>
                <select id="category" name="category" class="form-input">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex justify-end gap-2 border-t border-slate-100 bg-slate-50 px-6 py-4">
            <button type="button" class="btn btn-secondary" onclick="toggleModal('epimodal')">Cancelar</button>
            <button type="submit" class="btn btn-primary"><i data-lucide="check"></i>Criar EPI</button>
        </div>
    </form>
</x-ui.modal>
