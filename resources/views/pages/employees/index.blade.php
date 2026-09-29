@php
    $employees->loadMissing('user');
    $activeCount = $employees->where('status', 'Ativo')->count();
@endphp

<x-layouts.app title="Funcionários" subtitle="Gerencie o quadro de colaboradores da empresa" icon="users">
    <x-slot:modals>
        <x-modals.employee-create :roles="$roles" :sectors="$sectors" />
    </x-slot:modals>

    <x-slot:actions>
        <button type="button" onclick="toggleModal('modal')" class="btn btn-primary">
            <i data-lucide="user-plus"></i><span class="hidden sm:inline">Adicionar funcionário</span>
        </button>
    </x-slot:actions>

    <div class="flex flex-col gap-6">
        <div class="grid gap-4 sm:grid-cols-3">
            <x-ui.stat-card label="Total listado" :value="$employees->count()" icon="users" />
            <x-ui.stat-card label="Ativos" :value="$activeCount" icon="user-check" tone="success" />
            <x-ui.stat-card label="Inativos" :value="$employees->count() - $activeCount" icon="user-x" tone="danger" />
        </div>

        <div class="card overflow-hidden">
            {{-- Filtros --}}
            <form id="filter" method="GET" action="{{ route('employees.index') }}"
                class="flex flex-col gap-3 border-b border-slate-100 p-4 md:flex-row md:items-center">
                <div class="relative flex-1">
                    <i data-lucide="search" class="pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2 text-slate-400"></i>
                    <input class="form-input pl-9" placeholder="Buscar por nome..." type="search" name="search"
                        value="{{ $search ?? '' }}">
                </div>
                <div class="flex flex-wrap gap-3">
                    <select onchange="sendForm()" class="form-input w-auto" id="status" name="status">
                        <option value="">Todos os status</option>
                        <option value="Ativo" @selected(request('status') == 'Ativo')>Ativo</option>
                        <option value="Inativo" @selected(request('status') == 'Inativo')>Inativo</option>
                    </select>
                    <select onchange="sendForm()" class="form-input w-auto" id="sector" name="sector">
                        <option value="">Todos os setores</option>
                        @foreach ($sectors as $sector)
                            <option value="{{ $sector->id }}" @selected(request('sector') == $sector->id)>
                                {{ $sector->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-secondary">
                        <i data-lucide="filter"></i>Filtrar
                    </button>
                    <a href="{{ route('employees.index') }}" class="btn btn-ghost" title="Limpar filtros">
                        <i data-lucide="rotate-ccw"></i>
                    </a>
                </div>
            </form>

            {{-- Tabela --}}
            <form id="employee-form" method="POST" action="{{ route('employees.change') }}">
                @csrf
            </form>

            <div class="max-h-[60vh] overflow-y-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="w-10"></th>
                            <th>Funcionário</th>
                            <th class="hidden md:table-cell">Cargo / Setor</th>
                            <th class="hidden xl:table-cell">Admissão</th>
                            <th>Situação</th>
                            <th class="text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($employees as $employee)
                            <tr class="cursor-pointer has-checked:bg-brand-50" onclick="selectEmployee(this)">
                                <td>
                                    <input type="radio" form="employee-form" name="selected_employees"
                                        value="{{ $employee->id }}" class="size-4 accent-brand-700">
                                </td>
                                <td class="whitespace-normal">
                                    <div class="flex items-center gap-3">
                                        <x-ui.avatar :name="$employee->name" class="size-9 text-xs" />
                                        <div class="min-w-0">
                                            <p class="font-medium text-slate-900">{{ $employee->name }}</p>
                                            <p class="text-xs text-slate-500">
                                                <span class="font-mono">{{ $employee->registration }}</span>
                                                <span class="hidden lg:inline">· CPF <span class="font-mono">{{ $employee->cpf }}</span></span>
                                            </p>
                                            <p class="text-xs text-slate-500 md:hidden">
                                                {{ $employee->companyRole->title ?? 'N/A' }} · {{ $employee->sector->name ?? 'N/A' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="hidden whitespace-normal md:table-cell">
                                    <p class="text-slate-900">{{ $employee->companyRole->title ?? 'N/A' }}</p>
                                    <p class="text-xs text-slate-500">{{ $employee->sector->name ?? 'N/A' }}</p>
                                </td>
                                <td class="hidden xl:table-cell">
                                    {{ $employee->hire_date ? \Illuminate\Support\Carbon::parse($employee->hire_date)->format('d/m/Y') : '—' }}
                                </td>
                                <td>
                                    <div class="flex flex-col items-start gap-1">
                                        <span class="badge {{ $employee->status === 'Ativo' ? 'badge-success' : 'badge-danger' }}">
                                            {{ $employee->status }}
                                        </span>
                                        @if (! $employee->user)
                                            <span class="flex items-center gap-1 text-xs text-slate-400" title="Sem usuário no sistema">
                                                <i data-lucide="key-round" class="size-3"></i>Sem usuário
                                            </span>
                                        @elseif (! $employee->user->softdel)
                                            <span class="flex items-center gap-1 text-xs text-emerald-700" title="{{ $employee->user->email }}">
                                                <i data-lucide="key-round" class="size-3"></i>Acesso ativo
                                            </span>
                                        @else
                                            <span class="flex items-center gap-1 text-xs text-red-700" title="{{ $employee->user->email }}">
                                                <i data-lucide="key-round" class="size-3"></i>Acesso inativo
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="flex justify-end gap-1">
                                        <a href="{{ route('employees.profile', $employee->id) }}" class="icon-btn" title="Ver perfil">
                                            <i data-lucide="eye"></i>
                                        </a>
                                        <a href="{{ route('employees.viewUpdate', ['id' => $employee->id]) }}" class="icon-btn" title="Editar">
                                            <i data-lucide="pencil"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-16 text-center">
                                    <i data-lucide="search-x" class="mx-auto size-10 text-slate-300"></i>
                                    <p class="mt-3 font-medium text-slate-700">Nenhum funcionário encontrado</p>
                                    <p class="text-sm text-slate-500">Ajuste os filtros ou cadastre um novo funcionário.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col gap-3 border-t border-slate-100 bg-slate-50/60 px-4 py-3 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm text-slate-500">
                    Selecione um funcionário na lista para alterar o status.
                </p>
                <button type="submit" form="employee-form" class="btn btn-danger-soft">
                    <i data-lucide="power"></i>Ativar / Desativar selecionado
                </button>
            </div>
        </div>
    </div>
</x-layouts.app>
