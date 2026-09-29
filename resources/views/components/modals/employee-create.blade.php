@props(['roles', 'sectors', 'employee' => null])

<x-ui.modal id="modal" title="Novo funcionário" subtitle="A matrícula é gerada automaticamente." icon="user-plus">
    <form method="POST" action="{{ route('employees.create') }}">
        @csrf
        <div class="flex flex-col gap-4 px-6 py-5">
            <div>
                <label class="form-label" for="create_name">Nome completo</label>
                <input id="create_name" name="name" required placeholder="João da Silva" class="form-input" type="text" />
            </div>
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="form-label" for="create_cpf">CPF</label>
                    <input id="create_cpf" name="cpf" required placeholder="000.000.000-00" class="cpf form-input" type="text" />
                </div>
                <div>
                    <label class="form-label" for="create_hire_date">Data de contratação</label>
                    <input id="create_hire_date" name="hire_date" required class="form-input" type="date" />
                </div>
            </div>
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="form-label" for="create_company_role_id">Cargo</label>
                    <select id="create_company_role_id" name="company_role_id" class="form-input">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label" for="create_sector_id">Setor</label>
                    <select id="create_sector_id" required name="sector_id" class="form-input">
                        @foreach ($sectors as $sector)
                            <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="flex justify-end gap-2 border-t border-slate-100 bg-slate-50 px-6 py-4">
            <button type="button" class="btn btn-secondary" onclick="toggleModal('modal')">Cancelar</button>
            <button type="submit" class="btn btn-primary"><i data-lucide="check"></i>Criar funcionário</button>
        </div>
    </form>
</x-ui.modal>
