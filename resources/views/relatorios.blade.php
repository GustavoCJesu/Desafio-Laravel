@php
    // Dados estáticos para prototipação da interface
    $sectors = [
        ['name' => 'Produção', 'employees' => 46, 'trained' => 43, 'epis' => 212],
        ['name' => 'Manutenção', 'employees' => 22, 'trained' => 22, 'epis' => 138],
        ['name' => 'Logística', 'employees' => 19, 'trained' => 16, 'epis' => 74],
        ['name' => 'Qualidade', 'employees' => 14, 'trained' => 13, 'epis' => 41],
        ['name' => 'Administrativo', 'employees' => 17, 'trained' => 15, 'epis' => 12],
        ['name' => 'Almoxarifado', 'employees' => 10, 'trained' => 8, 'epis' => 33],
    ];
    $maxEmployees = max(array_column($sectors, 'employees'));

    $trainingHours = [
        ['nr' => 'NR-35', 'hours' => 320],
        ['nr' => 'NR-10', 'hours' => 280],
        ['nr' => 'NR-06', 'hours' => 196],
        ['nr' => 'NR-12', 'hours' => 176],
        ['nr' => 'NR-33', 'hours' => 144],
        ['nr' => 'NR-23', 'hours' => 124],
    ];
    $maxHours = max(array_column($trainingHours, 'hours'));

    $epiDeliveries = [
        ['month' => 'Out', 'value' => 38], ['month' => 'Nov', 'value' => 42], ['month' => 'Dez', 'value' => 25],
        ['month' => 'Jan', 'value' => 51], ['month' => 'Fev', 'value' => 47], ['month' => 'Mar', 'value' => 56],
        ['month' => 'Abr', 'value' => 44], ['month' => 'Mai', 'value' => 60], ['month' => 'Jun', 'value' => 53],
        ['month' => 'Jul', 'value' => 49], ['month' => 'Ago', 'value' => 64], ['month' => 'Set', 'value' => 58],
    ];
    $maxDeliveries = max(array_column($epiDeliveries, 'value'));

    $certificateStatus = [
        ['label' => 'Válidos', 'value' => 342, 'color' => 'bg-emerald-500', 'icon' => 'badge-check'],
        ['label' => 'A vencer', 'value' => 17, 'color' => 'bg-amber-400', 'icon' => 'alarm-clock'],
        ['label' => 'Vencidos', 'value' => 6, 'color' => 'bg-red-500', 'icon' => 'badge-x'],
    ];
    $totalCertificates = array_sum(array_column($certificateStatus, 'value'));
@endphp

<x-app-layout title="Relatórios" subtitle="Indicadores de pessoas, treinamentos e EPIs" icon="bar-chart-3">
    <x-slot:actions>
        <button type="button" onclick="window.print()" class="btn btn-secondary no-print">
            <i data-lucide="printer"></i><span class="hidden sm:inline">Imprimir</span>
        </button>
        <button type="button" class="btn btn-primary no-print">
            <i data-lucide="download"></i><span class="hidden sm:inline">Exportar</span>
        </button>
    </x-slot:actions>

    <div class="flex flex-col gap-6">
        {{-- Filtros --}}
        <div class="no-print flex flex-wrap items-center gap-3">
            <select class="form-input w-auto">
                <option>Últimos 12 meses</option>
                <option>Últimos 6 meses</option>
                <option>Este ano</option>
            </select>
            <select class="form-input w-auto">
                <option>Todos os setores</option>
                @foreach ($sectors as $sector)
                    <option>{{ $sector['name'] }}</option>
                @endforeach
            </select>
            <span class="text-xs text-slate-400">Atualizado em 29/09/2026 às 08:00</span>
        </div>

        {{-- Indicadores principais --}}
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <x-stat-card label="Funcionários" value="128" icon="users" hint="6 setores" />
            <x-stat-card label="Taxa de treinamento" value="91%" icon="graduation-cap" tone="success" hint="117 de 128 treinados" />
            <x-stat-card label="Horas de treinamento" value="1.240" icon="clock" tone="accent" hint="Últimos 12 meses" />
            <x-stat-card label="EPIs entregues" value="587" icon="hard-hat" tone="warning" hint="Últimos 12 meses" />
        </div>

        <div class="grid gap-6 xl:grid-cols-2">
            {{-- Funcionários por setor --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Funcionários por setor</h3>
                </div>
                <div class="flex flex-col gap-3 p-5">
                    @foreach ($sectors as $sector)
                        <div class="group grid grid-cols-[7rem_1fr_2.5rem] items-center gap-3 text-sm"
                            title="{{ $sector['name'] }}: {{ $sector['employees'] }} funcionários">
                            <span class="truncate text-slate-600">{{ $sector['name'] }}</span>
                            <div class="h-5 rounded-r bg-slate-100">
                                <div class="h-full rounded-r bg-brand-500 transition group-hover:bg-accent-500"
                                    style="width: {{ $sector['employees'] * 100 / $maxEmployees }}%"></div>
                            </div>
                            <span class="text-right font-semibold text-slate-700">{{ $sector['employees'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Horas de treinamento por norma --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Horas de treinamento por norma</h3>
                </div>
                <div class="flex flex-col gap-3 p-5">
                    @foreach ($trainingHours as $training)
                        <div class="group grid grid-cols-[7rem_1fr_2.5rem] items-center gap-3 text-sm"
                            title="{{ $training['nr'] }}: {{ $training['hours'] }} horas">
                            <span class="text-slate-600">{{ $training['nr'] }}</span>
                            <div class="h-5 rounded-r bg-slate-100">
                                <div class="h-full rounded-r bg-brand-500 transition group-hover:bg-accent-500"
                                    style="width: {{ $training['hours'] * 100 / $maxHours }}%"></div>
                            </div>
                            <span class="text-right font-semibold text-slate-700">{{ $training['hours'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-3">
            {{-- Entregas de EPI por mês --}}
            <div class="card xl:col-span-2">
                <div class="card-header">
                    <div>
                        <h3 class="card-title">Entregas de EPI por mês</h3>
                        <p class="text-xs text-slate-500">Unidades entregues aos funcionários</p>
                    </div>
                </div>
                <div class="card-body">
                    <div class="flex h-52 items-end gap-1.5 border-b border-slate-200 sm:gap-3">
                        @foreach ($epiDeliveries as $delivery)
                            <div class="group flex h-full flex-1 flex-col items-center justify-end"
                                title="{{ $delivery['month'] }}: {{ $delivery['value'] }} entregas">
                                <span class="mb-1 text-[11px] font-semibold text-slate-600 opacity-0 transition group-hover:opacity-100">
                                    {{ $delivery['value'] }}
                                </span>
                                <div class="w-full rounded-t bg-brand-500 transition group-hover:bg-accent-500"
                                    style="height: {{ $delivery['value'] * 100 / $maxDeliveries }}%"></div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-2 flex gap-1.5 sm:gap-3">
                        @foreach ($epiDeliveries as $delivery)
                            <span class="flex-1 text-center text-[11px] text-slate-500">{{ $delivery['month'] }}</span>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Situação dos certificados --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Situação dos certificados</h3>
                    <span class="text-xs text-slate-500">{{ $totalCertificates }} no total</span>
                </div>
                <div class="card-body">
                    <p class="text-3xl font-bold text-slate-900">{{ round($certificateStatus[0]['value'] * 100 / $totalCertificates) }}%</p>
                    <p class="text-sm text-slate-500">dos certificados estão válidos</p>

                    <div class="mt-5 flex h-3 gap-0.5 overflow-hidden rounded-full">
                        @foreach ($certificateStatus as $status)
                            <div class="{{ $status['color'] }} h-full" style="width: {{ $status['value'] * 100 / $totalCertificates }}%"
                                title="{{ $status['label'] }}: {{ $status['value'] }}"></div>
                        @endforeach
                    </div>

                    <ul class="mt-5 flex flex-col gap-3">
                        @foreach ($certificateStatus as $status)
                            <li class="flex items-center gap-3 text-sm">
                                <span class="{{ $status['color'] }} size-2.5 rounded-full"></span>
                                <i data-lucide="{{ $status['icon'] }}" class="size-4 text-slate-400"></i>
                                <span class="flex-1 text-slate-600">{{ $status['label'] }}</span>
                                <span class="font-semibold text-slate-900">{{ $status['value'] }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        {{-- Tabela resumo --}}
        <div class="card overflow-hidden">
            <div class="card-header">
                <h3 class="card-title">Resumo por setor</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Setor</th>
                            <th class="text-right">Funcionários</th>
                            <th class="text-right">Treinados</th>
                            <th>Conformidade</th>
                            <th class="text-right">EPIs entregues</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sectors as $sector)
                            @php
                                $compliance = round($sector['trained'] * 100 / $sector['employees']);
                            @endphp
                            <tr>
                                <td class="font-medium text-slate-900">{{ $sector['name'] }}</td>
                                <td class="text-right">{{ $sector['employees'] }}</td>
                                <td class="text-right">{{ $sector['trained'] }}</td>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="h-1.5 w-24 overflow-hidden rounded-full bg-slate-100">
                                            <div class="h-full rounded-full {{ $compliance >= 90 ? 'bg-emerald-500' : 'bg-amber-400' }}"
                                                style="width: {{ $compliance }}%"></div>
                                        </div>
                                        <span class="text-xs font-semibold {{ $compliance >= 90 ? 'text-emerald-700' : 'text-amber-700' }}">{{ $compliance }}%</span>
                                    </div>
                                </td>
                                <td class="text-right">{{ $sector['epis'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
