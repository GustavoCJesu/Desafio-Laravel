@php
    $details = [
        ['hash', 'Matrícula', $employee->registration],
        ['id-card', 'CPF', $employee->cpf],
        ['briefcase', 'Cargo', $employee->companyRole->title ?? 'N/A'],
        ['building-2', 'Setor', $employee->sector->name ?? 'N/A'],
        ['calendar', 'Data de contratação', $employee->hire_date ? \Illuminate\Support\Carbon::parse($employee->hire_date)->format('d/m/Y') : '—'],
    ];
@endphp

<x-layouts.app title="Perfil do funcionário" :subtitle="$employee->name" icon="id-card">
    <x-slot:actions>
        <a href="{{ route('employees.index') }}" class="btn btn-secondary">
            <i data-lucide="arrow-left"></i><span class="hidden sm:inline">Voltar</span>
        </a>
        @can('employees.update')
            <a href="{{ route('employees.viewUpdate', ['id' => $employee->id]) }}" class="btn btn-primary">
                <i data-lucide="pencil"></i><span class="hidden sm:inline">Editar</span>
            </a>
        @endcan
    </x-slot:actions>

    <div class="mx-auto flex max-w-5xl flex-col gap-6">
        {{-- Cabeçalho do perfil --}}
        <div class="card overflow-hidden">
            <div class="bg-gradient-primary h-28"></div>
            <div class="flex flex-col gap-4 px-6 pb-6 sm:flex-row sm:items-end">
                <x-ui.avatar :name="$employee->name" class="-mt-12 size-24 border-4 border-white text-3xl shadow-md" />
                <div class="flex-1">
                    <h2 class="text-xl font-bold text-slate-900">{{ $employee->name }}</h2>
                    <p class="text-sm text-slate-500">
                        {{ $employee->companyRole->title ?? 'Sem cargo' }} · {{ $employee->sector->name ?? 'Sem setor' }}
                    </p>
                </div>
                <span class="badge {{ $employee->status === 'Ativo' ? 'badge-success' : 'badge-danger' }} self-start sm:self-auto">
                    {{ $employee->status }}
                </span>
            </div>
        </div>

        <div class="grid items-start gap-6 lg:grid-cols-3">
            {{-- Informações do funcionário --}}
            <div class="card lg:col-span-2">
                <div class="card-header">
                    <h3 class="card-title">Informações do funcionário</h3>
                </div>
                <dl class="grid gap-x-6 gap-y-5 p-5 sm:grid-cols-2">
                    @foreach ($details as [$icon, $label, $value])
                        <div class="flex gap-3">
                            <div class="flex size-9 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-slate-500">
                                <i data-lucide="{{ $icon }}" class="size-4"></i>
                            </div>
                            <div class="min-w-0">
                                <dt class="text-xs text-slate-500">{{ $label }}</dt>
                                <dd class="truncate font-medium text-slate-900">{{ $value }}</dd>
                            </div>
                        </div>
                    @endforeach
                </dl>
            </div>

            {{-- Informações do usuário --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Acesso ao sistema</h3>
                    <i data-lucide="key-round" class="size-4 text-slate-400"></i>
                </div>
                @if ($employee->user)
                    <dl class="flex flex-col gap-4 p-5">
                        <div>
                            <dt class="text-xs text-slate-500">E-mail</dt>
                            <dd class="truncate font-medium text-slate-900">{{ $employee->user->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-slate-500">Cargo do sistema</dt>
                            <dd class="font-medium text-slate-900">{{ $employee->user->userRole->title ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="mb-1 text-xs text-slate-500">Status do usuário</dt>
                            <dd>
                                <span class="badge {{ $employee->user->softdel === 0 ? 'badge-success' : 'badge-danger' }}">
                                    {{ $employee->user->softdel === 0 ? 'Ativo' : 'Inativo' }}
                                </span>
                            </dd>
                        </div>
                    </dl>
                @else
                    <div class="flex flex-col items-center p-8 text-center">
                        <i data-lucide="user-round-x" class="size-8 text-slate-300"></i>
                        <p class="mt-2 text-sm text-slate-500">Este funcionário não possui usuário no sistema.</p>
                        @can('employees.update')
                            <a href="{{ route('employees.viewUpdate', ['id' => $employee->id]) }}" class="btn btn-secondary btn-sm mt-4">
                                Criar usuário
                            </a>
                        @endcan
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>
