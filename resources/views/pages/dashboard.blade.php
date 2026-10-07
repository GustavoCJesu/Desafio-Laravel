@php
    // Dados estáticos para prototipação da interface
    $stats = [
        ['label' => 'Funcionários ativos', 'value' => 128, 'icon' => 'users', 'tone' => 'brand', 'hint' => '+6 este mês'],
        ['label' => 'Aulas agendadas', 'value' => 9, 'icon' => 'calendar-clock', 'tone' => 'accent', 'hint' => 'Próximos 30 dias'],
        ['label' => 'Certificados válidos', 'value' => 342, 'icon' => 'award', 'tone' => 'success', 'hint' => '94% de conformidade'],
        ['label' => 'A vencer', 'value' => 17, 'icon' => 'alert-triangle', 'tone' => 'warning', 'hint' => 'Nos próximos 60 dias'],
    ];

    $monthlyTrainings = [
        ['month' => 'Abr', 'value' => 14],
        ['month' => 'Mai', 'value' => 22],
        ['month' => 'Jun', 'value' => 18],
        ['month' => 'Jul', 'value' => 27],
        ['month' => 'Ago', 'value' => 31],
        ['month' => 'Set', 'value' => 24],
    ];
    $maxTrainings = max(array_column($monthlyTrainings, 'value'));

    $upcomingClasses = [
        ['title' => 'NR-35 Trabalho em Altura', 'date' => '02/10', 'time' => '08:00', 'instructor' => 'Carlos Mendes', 'seats' => '18/20'],
        ['title' => 'NR-06 Uso correto de EPI', 'date' => '05/10', 'time' => '14:00', 'instructor' => 'Fernanda Rocha', 'seats' => '25/30'],
        ['title' => 'NR-10 Segurança em Eletricidade', 'date' => '09/10', 'time' => '08:30', 'instructor' => 'Ricardo Alves', 'seats' => '12/15'],
        ['title' => 'NR-33 Espaço Confinado', 'date' => '14/10', 'time' => '09:00', 'instructor' => 'Carlos Mendes', 'seats' => '8/12'],
    ];

    $expiring = [
        ['name' => 'Ana Paula Souza', 'item' => 'NR-35 Trabalho em Altura', 'days' => 5],
        ['name' => 'Bruno Costa', 'item' => 'NR-10 Segurança em Eletricidade', 'days' => 12],
        ['name' => 'Juliana Martins', 'item' => 'NR-06 Uso de EPI', 'days' => 21],
        ['name' => 'Marcos Oliveira', 'item' => 'NR-33 Espaço Confinado', 'days' => 38],
        ['name' => 'Patrícia Lima', 'item' => 'NR-12 Máquinas e Equipamentos', 'days' => 54],
    ];

    $activities = [
        ['icon' => 'user-plus', 'text' => 'Funcionário <b>Lucas Ferreira</b> cadastrado', 'time' => 'há 12 min'],
        ['icon' => 'award', 'text' => 'Certificado NR-06 emitido para <b>12 funcionários</b>', 'time' => 'há 1 h'],
        ['icon' => 'hard-hat', 'text' => 'EPI <b>Luva nitrílica CA 38765</b> atualizado', 'time' => 'há 3 h'],
        ['icon' => 'calendar-plus', 'text' => 'Aula <b>NR-33 Espaço Confinado</b> agendada', 'time' => 'ontem'],
    ];
@endphp

<x-layouts.app title="Painel" subtitle="Resumo geral de pessoas, treinamentos e segurança" icon="layout-dashboard">
    <x-slot:actions>
        @can('reports.view')
            <a href="{{ route('report.index') }}" class="btn btn-secondary">
                <i data-lucide="bar-chart-3"></i><span class="hidden sm:inline">Relatórios</span>
            </a>
        @endcan
    </x-slot:actions>

    <div class="flex flex-col gap-6">
        {{-- Boas-vindas --}}
        <div class="bg-gradient-primary relative overflow-hidden rounded-2xl p-6 text-white shadow-elevated sm:p-8">
            <div class="pointer-events-none absolute -top-16 -right-10 size-64 rounded-full bg-white/10"></div>
            <div class="pointer-events-none absolute -right-24 -bottom-24 size-72 rounded-full bg-white/5"></div>
            <div class="relative flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-brand-100">Olá, {{ explode(' ', auth()->user()->employee->name ?? 'usuário')[0] }} 👋</p>
                    <h2 class="mt-1 text-2xl font-bold">Você tem 17 certificados próximos do vencimento</h2>
                    <p class="mt-1 text-sm text-brand-100">Agende as reciclagens para manter a equipe em conformidade.</p>
                </div>
                @can('trainings.view')
                    <a href="{{ route('training.index') }}" class="btn shrink-0 bg-white text-brand-800 hover:bg-brand-50">
                        <i data-lucide="calendar-plus"></i>Ver aulas
                    </a>
                @endcan
            </div>
        </div>

        {{-- Indicadores --}}
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($stats as $stat)
                <x-ui.stat-card :label="$stat['label']" :value="$stat['value']" :icon="$stat['icon']" :tone="$stat['tone']" :hint="$stat['hint']" />
            @endforeach
        </div>

        <div class="grid gap-6 xl:grid-cols-3">
            {{-- Gráfico de treinamentos por mês --}}
            <div class="card xl:col-span-2">
                <div class="card-header">
                    <div>
                        <h3 class="card-title">Funcionários treinados por mês</h3>
                        <p class="text-xs text-slate-500">Últimos 6 meses</p>
                    </div>
                    <span class="badge badge-success">+18% vs. semestre anterior</span>
                </div>
                <div class="card-body">
                    <div class="flex h-56 items-end gap-3 border-b border-slate-200 sm:gap-6">
                        @foreach ($monthlyTrainings as $month)
                            <div class="group relative flex h-full flex-1 flex-col items-center justify-end">
                                <span class="mb-1 text-xs font-semibold text-slate-600 opacity-0 transition group-hover:opacity-100">
                                    {{ $month['value'] }}
                                </span>
                                <div class="w-full max-w-12 rounded-t-md bg-brand-500 transition group-hover:bg-accent-500"
                                    style="height: {{ $month['value'] * 100 / $maxTrainings }}%"
                                    title="{{ $month['month'] }}: {{ $month['value'] }} funcionários"></div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-2 flex gap-3 sm:gap-6">
                        @foreach ($monthlyTrainings as $month)
                            <span class="flex-1 text-center text-xs text-slate-500">{{ $month['month'] }}</span>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Atividades recentes --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Atividade recente</h3>
                </div>
                <ul class="flex flex-col gap-5 p-5">
                    @foreach ($activities as $activity)
                        <li class="flex gap-3">
                            <div class="flex size-8 shrink-0 items-center justify-center rounded-full bg-brand-50 text-brand-600">
                                <i data-lucide="{{ $activity['icon'] }}" class="size-4"></i>
                            </div>
                            <div class="text-sm">
                                <p class="text-slate-700 [&_b]:font-semibold [&_b]:text-slate-900">{!! $activity['text'] !!}</p>
                                <p class="text-xs text-slate-400">{{ $activity['time'] }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-2">
            {{-- Próximas aulas --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Próximas aulas</h3>
                    @can('trainings.view')
                        <a href="{{ route('training.index') }}" class="text-xs font-semibold text-accent-600 hover:underline">Ver todas</a>
                    @endcan
                </div>
                <ul class="divide-y divide-slate-100">
                    @foreach ($upcomingClasses as $class)
                        <li class="flex items-center gap-4 px-5 py-3">
                            <div class="flex w-12 shrink-0 flex-col items-center rounded-lg bg-brand-50 py-1.5 text-brand-700">
                                <span class="text-sm font-bold">{{ explode('/', $class['date'])[0] }}</span>
                                <span class="text-[10px] uppercase">Out</span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium text-slate-900">{{ $class['title'] }}</p>
                                <p class="text-xs text-slate-500">{{ $class['time'] }} · {{ $class['instructor'] }}</p>
                            </div>
                            <span class="flex items-center gap-1 text-xs text-slate-500">
                                <i data-lucide="users" class="size-3.5"></i>{{ $class['seats'] }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Certificados a vencer --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Certificados a vencer</h3>
                    <a href="{{ route('certificate.index') }}" class="text-xs font-semibold text-accent-600 hover:underline">Ver todos</a>
                </div>
                <ul class="divide-y divide-slate-100">
                    @foreach ($expiring as $item)
                        <li class="flex items-center gap-3 px-5 py-3">
                            <x-ui.avatar :name="$item['name']" class="size-9 text-xs" />
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium text-slate-900">{{ $item['name'] }}</p>
                                <p class="truncate text-xs text-slate-500">{{ $item['item'] }}</p>
                            </div>
                            <span class="badge {{ $item['days'] <= 15 ? 'badge-danger' : ($item['days'] <= 30 ? 'badge-warning' : 'badge-neutral') }}">
                                {{ $item['days'] }} dias
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-layouts.app>
