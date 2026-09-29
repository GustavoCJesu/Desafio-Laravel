@props(['employee' => null, 'user_roles'])

<x-modal id="userModal" title="Novo usuário" subtitle="Libere o acesso deste funcionário ao sistema." icon="key-round">
    <form method="POST" action="{{ route('user.create') }}">
        @csrf
        <input name="employee_id" type="hidden" value="{{ $employee->id }}">
        <div class="flex flex-col gap-4 px-6 py-5">
            <div>
                <label class="form-label" for="employee_name">Funcionário</label>
                <input id="employee_name" value="{{ $employee->name }}" name="employee_name" readonly class="form-input" type="text" />
            </div>
            <div>
                <label class="form-label" for="new_user_email">E-mail</label>
                <input id="new_user_email" required name="email" placeholder="nome@empresa.com" class="form-input" type="email" />
            </div>
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="form-label" for="new_user_password">Senha</label>
                    <input id="new_user_password" required name="password" class="form-input" type="password" />
                </div>
                <div>
                    <label class="form-label" for="new_user_password_confirmation">Confirmar senha</label>
                    <input id="new_user_password_confirmation" required name="password_confirmation" class="form-input" type="password" />
                </div>
            </div>
            <div>
                <label class="form-label" for="new_user_role">Função</label>
                <select id="new_user_role" class="form-input" name="user_role_id">
                    @foreach ($user_roles as $role)
                        <option value="{{ $role->id }}">{{ $role->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex justify-end gap-2 border-t border-slate-100 bg-slate-50 px-6 py-4">
            <button type="button" class="btn btn-secondary" onclick="toggleModal('userModal')">Cancelar</button>
            <button type="submit" class="btn btn-primary"><i data-lucide="check"></i>Criar usuário</button>
        </div>
    </form>
</x-modal>
