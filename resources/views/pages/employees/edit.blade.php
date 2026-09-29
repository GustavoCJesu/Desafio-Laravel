@php
    $hasUser = $users->contains('employee_id', $employee->id);
@endphp

<x-layouts.app title="Editar funcionário" :subtitle="$employee->name" icon="user-pen">
    @unless ($hasUser)
        <x-slot:modals>
            <x-modals.user-create :employee="$employee" :user_roles="$user_roles" />
        </x-slot:modals>
    @endunless

    <x-slot:actions>
        <a href="{{ route('employees.index') }}" class="btn btn-secondary">
            <i data-lucide="arrow-left"></i><span class="hidden sm:inline">Voltar</span>
        </a>
        <a href="{{ route('employees.profile', $employee->id) }}" class="btn btn-secondary">
            <i data-lucide="eye"></i><span class="hidden sm:inline">Ver perfil</span>
        </a>
    </x-slot:actions>

    <div class="mx-auto grid max-w-6xl items-start gap-6 xl:grid-cols-2">
        {{-- Cadastro do funcionário --}}
        <form class="card" method="POST" action="{{ route('employee.update', $employee->id) }}">
            @csrf
            @method('PUT')
            <div class="card-header">
                <div class="flex items-center gap-3">
                    <x-ui.avatar :name="$employee->name" class="size-10 text-sm" />
                    <div>
                        <h2 class="card-title">Cadastro do funcionário</h2>
                        <p class="text-xs text-slate-500">Matrícula {{ $employee->registration }}</p>
                    </div>
                </div>
                <span class="badge {{ $employee->status === 'Ativo' ? 'badge-success' : 'badge-danger' }}">
                    {{ $employee->status }}
                </span>
            </div>

            <div class="card-body grid gap-4 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label class="form-label" for="name">Nome completo</label>
                    <input id="name" name="name" class="form-input" type="text" value="{{ $employee->name }}" />
                </div>
                <div>
                    <label class="form-label" for="cpf">CPF</label>
                    <input id="cpf" name="cpf" class="cpf form-input" type="text" value="{{ $employee->cpf }}" />
                </div>
                <div>
                    <label class="form-label" for="registration">Matrícula</label>
                    <input id="registration" name="registration" readonly class="form-input" type="text"
                        value="{{ $employee->registration }}" />
                </div>
                <div>
                    <label class="form-label" for="sector_id">Setor</label>
                    <select id="sector_id" name="sector_id" class="form-input">
                        @foreach ($sectors as $sector)
                            <option value="{{ $sector->id }}" @selected($employee->sector_id === $sector->id)>
                                {{ $sector->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label" for="company_role_id">Cargo</label>
                    <select id="company_role_id" name="company_role_id" class="form-input">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" @selected($employee->company_role_id === $role->id)>
                                {{ $role->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label" for="hire_date">Data de contratação</label>
                    <input id="hire_date" name="hire_date" type="text" readonly class="form-input"
                        value="{{ $employee->hire_date }}" />
                </div>
            </div>

            <div class="flex justify-end gap-2 border-t border-slate-100 bg-slate-50/60 px-5 py-4">
                <a href="{{ route('employees.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary"><i data-lucide="save"></i>Salvar alterações</button>
            </div>
        </form>

        {{-- Usuário do sistema --}}
        @if ($hasUser)
            <form class="card" action="{{ route('user.update', $employee->user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-header">
                    <div class="flex items-center gap-3">
                        <div class="flex size-10 items-center justify-center rounded-full bg-indigo-100 text-accent-600">
                            <i data-lucide="key-round" class="size-5"></i>
                        </div>
                        <div>
                            <h2 class="card-title">Acesso ao sistema</h2>
                            <p class="text-xs text-slate-500">Dados de login e permissões</p>
                        </div>
                    </div>
                </div>

                <div class="card-body flex flex-col gap-4">
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="form-label" for="user_email">E-mail</label>
                            <input id="user_email" name="email" readonly class="form-input" type="text"
                                value="{{ $employee->user->email }}" />
                        </div>
                        <div>
                            <label class="form-label" for="user_role_id">Função do usuário</label>
                            <select id="user_role_id" name="user_role_id" class="form-input">
                                @foreach ($user_roles as $role)
                                    <option value="{{ $role->id }}" @selected($employee->user->userRole->id === $role->id)>
                                        {{ $role->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <p class="form-label">Permissões da função</p>
                        <x-ui.permission-grid :grouped="$grouped" readonly
                            :selected="$employee->user->userRole->rolePermissions->pluck('permission_id')->all()" />
                    </div>
                </div>

                <div class="flex justify-end gap-2 border-t border-slate-100 bg-slate-50/60 px-5 py-4">
                    <button type="submit" class="btn btn-primary"><i data-lucide="save"></i>Salvar usuário</button>
                </div>
            </form>
        @else
            <div class="card flex flex-col items-center px-6 py-12 text-center">
                <div class="flex size-14 items-center justify-center rounded-full bg-brand-100 text-brand-700">
                    <i data-lucide="user-round-x" class="size-7"></i>
                </div>
                <h2 class="mt-4 font-semibold text-slate-900">Sem acesso ao sistema</h2>
                <p class="mt-1 max-w-xs text-sm text-slate-500">
                    Este funcionário ainda não possui um usuário. Crie um para que ele possa fazer login.
                </p>
                <button type="button" onclick="toggleModal('userModal')" class="btn btn-primary mt-6">
                    <i data-lucide="user-plus"></i>Criar usuário
                </button>
            </div>
        @endif
    </div>
</x-layouts.app>
