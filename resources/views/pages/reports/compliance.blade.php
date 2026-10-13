@php
    $statusBadges = [
        'Válido' => 'badge-success',
        'A vencer' => 'badge-warning',
        'Vencido' => 'badge-danger',
        'Pendente' => 'badge-info',
        'Certificado não emitido' => 'badge-warning',
        'Reprovado por carga horária' => 'badge-danger',
    ];
    $documentCode = 'REL-'.$issuedAt->format('Ymd-His');
    $exportQuery = array_filter($filters, fn ($value) => $value !== null && $value !== '');
@endphp

<x-layouts.base title="Relatório de conformidade">
    {{-- Barra de comandos (não vai para a impressão) --}}
    <div class="no-print sticky top-0 z-10 border-b border-slate-200 bg-white/90 backdrop-blur">
        <div class="mx-auto flex max-w-6xl flex-wrap items-center gap-3 px-4 py-3 sm:px-8">
            <a href="{{ route('report.index') }}" class="btn btn-secondary">
                <i data-lucide="arrow-left"></i><span class="hidden sm:inline">Relatórios</span>
            </a>

            <form method="GET" action="{{ route('report.compliance') }}" class="flex flex-1 flex-wrap items-center gap-2">
                <select name="sector_id" class="form-input w-auto" aria-label="Setor">
                    <option value="">Todos os setores</option>
                    @foreach ($sectors as $sector)
                        <option value="{{ $sector->id }}" @selected((int) ($filters['sector_id'] ?? 0) === $sector->id)>{{ $sector->name }}</option>
                    @endforeach
                </select>
                <select name="norm" class="form-input w-auto" aria-label="Norma">
                    <option value="">Todas as normas</option>
                    @foreach ($norms as $norm)
                        <option value="{{ $norm }}" @selected(($filters['norm'] ?? null) === $norm)>{{ $norm }}</option>
                    @endforeach
                </select>
                <label class="flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="only_pending" value="1" class="size-4 accent-brand-700"
                        @checked($filters['only_pending'] ?? false)>
                    Somente pendências
                </label>
                <button type="submit" class="btn btn-secondary"><i data-lucide="filter"></i>Aplicar</button>
            </form>

            @can('reports.export')
                <a href="{{ route('report.compliance.export', $exportQuery) }}" class="btn btn-secondary">
                    <i data-lucide="download"></i><span class="hidden sm:inline">Exportar CSV</span>
                </a>
            @endcan
            <button type="button" onclick="window.print()" class="btn btn-primary">
                <i data-lucide="printer"></i><span class="hidden sm:inline">Imprimir / salvar PDF</span>
            </button>
        </div>
    </div>

    <main class="mx-auto my-6 w-full max-w-6xl px-4 sm:px-8 print:my-0 print:max-w-none print:px-0">
        <article class="flex flex-col gap-8 rounded-xl bg-white p-6 shadow-card ring-1 ring-slate-200 sm:p-10 print:rounded-none print:p-0 print:shadow-none print:ring-0">
            {{-- Identificação do documento --}}
            <header class="flex flex-col gap-4 border-b-2 border-brand-700 pb-5 sm:flex-row sm:items-start sm:justify-between">
                <div class="flex items-start gap-3">
                    <div class="flex size-11 shrink-0 items-center justify-center rounded-lg bg-brand-700 text-white">
                        <i data-lucide="shield-check" class="size-6"></i>
                    </div>
                    <div>
                        <p class="text-xs font-semibold tracking-wider text-brand-500 uppercase">Gestão SST · Pessoas & Segurança</p>
                        <h1 class="text-xl font-bold text-slate-900 sm:text-2xl">Relatório de conformidade</h1>
                        <p class="text-sm text-slate-500">Treinamentos, certificados e EPIs — evidência para auditoria</p>
                    </div>
                </div>
                <dl class="grid grid-cols-[auto_1fr] gap-x-3 gap-y-1 text-sm sm:text-right">
                    <dt class="text-slate-500 sm:col-start-1">Documento</dt>
                    <dd class="font-mono font-semibold text-slate-900">{{ $documentCode }}</dd>
                    <dt class="text-slate-500">Emitido em</dt>
                    <dd class="font-semibold text-slate-900">{{ $issuedAt->format('d/m/Y \à\s H:i') }}</dd>
                    <dt class="text-slate-500">Emitido por</dt>
                    <dd class="font-semibold text-slate-900">{{ $issuedBy }}@if ($issuedByRole) <span class="font-normal text-slate-500">({{ $issuedByRole }})</span>@endif</dd>
                </dl>
            </header>

            {{-- Escopo --}}
            <section class="print-avoid-break">
                <h2 class="text-sm font-semibold tracking-wide text-slate-900 uppercase">1. Escopo</h2>
                <dl class="mt-3 grid gap-x-8 gap-y-2 text-sm sm:grid-cols-2">
                    <div class="flex gap-2"><dt class="text-slate-500">Data de referência:</dt><dd class="font-medium">{{ $issuedAt->format('d/m/Y') }}</dd></div>
                    <div class="flex gap-2"><dt class="text-slate-500">Setor:</dt><dd class="font-medium">{{ $sectorName ?? 'Todos' }}</dd></div>
                    <div class="flex gap-2"><dt class="text-slate-500">Norma:</dt><dd class="font-medium">{{ $filters['norm'] ?? 'Todas' }}</dd></div>
                    <div class="flex gap-2"><dt class="text-slate-500">Listagem:</dt><dd class="font-medium">{{ ($filters['only_pending'] ?? false) ? 'Somente pendências' : 'Todos os registros' }}</dd></div>
                </dl>
                <p class="mt-3 text-xs leading-relaxed text-slate-500">
                    Consideram-se os funcionários <b>ativos</b> convocados para treinamentos não cancelados. Cada funcionário é avaliado uma vez por norma,
                    pelo certificado mais favorável. São considerados <b>em conformidade</b> os certificados <b>Válidos</b> e <b>A vencer</b>
                    (vencimento em até 60 dias). Os indicadores abaixo valem para todo o escopo, mesmo quando a listagem mostra só as pendências.
                </p>
            </section>

            {{-- Indicadores --}}
            <section class="print-avoid-break">
                <h2 class="text-sm font-semibold tracking-wide text-slate-900 uppercase">2. Indicadores gerais</h2>
                <div class="mt-3 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <x-ui.stat-card label="Índice de conformidade" value="{{ $summary['rate'] }}%" icon="shield-check"
                        :tone="$summary['rate'] >= 90 ? 'success' : 'warning'" hint="{{ $summary['compliant'] }} de {{ $summary['requirements'] }} exigências" />
                    <x-ui.stat-card label="Funcionários avaliados" value="{{ $summary['employees'] }}" icon="users"
                        hint="{{ $summary['employees_compliant'] }} totalmente conformes" />
                    <x-ui.stat-card label="Certificados a vencer" value="{{ $summary['by_status']['A vencer'] }}" icon="alarm-clock" tone="warning" hint="Até 60 dias" />
                    <x-ui.stat-card label="Irregularidades" value="{{ $summary['requirements'] - $summary['compliant'] }}" icon="triangle-alert" tone="danger"
                        hint="Vencidos, pendentes e reprovados" />
                </div>

                <ul class="mt-4 flex flex-wrap gap-2 text-sm">
                    @foreach ($summary['by_status'] as $status => $total)
                        <li class="flex items-center gap-2 rounded-lg border border-slate-200 px-3 py-1.5">
                            <span class="badge {{ $statusBadges[$status] }}">{{ $status }}</span>
                            <span class="font-semibold text-slate-900">{{ $total }}</span>
                        </li>
                    @endforeach
                </ul>
            </section>

            {{-- Conformidade por norma e por setor --}}
            <section class="grid gap-6 lg:grid-cols-2">
                @foreach ([['3. Conformidade por norma', 'Norma', $byNorm], ['4. Conformidade por setor', 'Setor', $bySector]] as [$heading, $label, $groups])
                    <div class="print-avoid-break">
                        <h2 class="text-sm font-semibold tracking-wide text-slate-900 uppercase">{{ $heading }}</h2>
                        <table class="data-table mt-3">
                            <thead>
                                <tr>
                                    <th>{{ $label }}</th>
                                    <th class="text-right">Exigências</th>
                                    <th class="text-right">Conformes</th>
                                    <th class="text-right">Índice</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($groups as $name => $group)
                                    <tr>
                                        <td class="font-medium text-slate-900">{{ $name }}</td>
                                        <td class="text-right">{{ $group['total'] }}</td>
                                        <td class="text-right">{{ $group['compliant'] }}</td>
                                        <td class="text-right font-semibold {{ $group['rate'] >= 90 ? 'text-emerald-700' : 'text-amber-700' }}">{{ $group['rate'] }}%</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="py-6 text-center text-slate-400">Sem registros no escopo.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </section>

            {{-- Evidências: registro por funcionário --}}
            <section>
                <h2 class="text-sm font-semibold tracking-wide text-slate-900 uppercase">5. Registro de evidências por funcionário</h2>
                <p class="mt-1 text-xs text-slate-500">{{ $visibleRows->count() }} {{ $visibleRows->count() === 1 ? 'registro' : 'registros' }} listados.</p>
                <div class="mt-3 overflow-x-auto print:overflow-visible">
                    <table class="data-table text-xs">
                        <thead>
                            <tr>
                                <th>Funcionário</th>
                                <th>Setor</th>
                                <th>Norma / treinamento</th>
                                <th>Situação</th>
                                <th class="text-right">Carga (h)</th>
                                <th>Certificado</th>
                                <th>Emissão</th>
                                <th>Validade</th>
                                <th>EPIs abordados</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($visibleRows as $row)
                                <tr>
                                    <td class="whitespace-normal">
                                        <p class="font-medium text-slate-900">{{ $row['employee'] }}</p>
                                        <p class="font-mono text-slate-500">{{ $row['registration'] }}</p>
                                    </td>
                                    <td class="whitespace-normal">{{ $row['sector'] }}</td>
                                    <td class="whitespace-normal">
                                        <p class="font-medium text-slate-900">{{ $row['norm'] }}</p>
                                        <p class="text-slate-500">{{ $row['title'] }}</p>
                                        <p class="text-slate-400">Instrutor: {{ $row['instructor'] }}</p>
                                    </td>
                                    <td class="whitespace-normal"><span class="badge {{ $statusBadges[$row['status']] }}">{{ $row['status'] }}</span></td>
                                    <td class="text-right">
                                        {{ $row['attended_hours'] + 0 }}/{{ $row['hours'] }}
                                        <p class="text-slate-400">mín. {{ $row['min_hours'] }}</p>
                                    </td>
                                    <td class="font-mono">{{ $row['code'] ?? '—' }}</td>
                                    <td>{{ $row['issued_at'] ?? '—' }}</td>
                                    <td>{{ $row['expires_at'] ?? '—' }}</td>
                                    <td class="whitespace-normal">{{ $row['epis'] ? implode(', ', $row['epis']) : '—' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="9" class="py-10 text-center text-slate-400">Nenhum registro para os filtros selecionados.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <p class="mt-2 text-[11px] text-slate-400">Carga: horas cumpridas pelo funcionário / carga horária do treinamento.</p>
            </section>

            {{-- Treinamentos considerados --}}
            <section>
                <h2 class="text-sm font-semibold tracking-wide text-slate-900 uppercase">6. Treinamentos considerados</h2>
                <div class="mt-3 overflow-x-auto print:overflow-visible">
                    <table class="data-table text-xs">
                        <thead>
                            <tr>
                                <th>Norma</th>
                                <th>Treinamento</th>
                                <th>Situação</th>
                                <th>Instrutor</th>
                                <th class="text-right">Carga (h)</th>
                                <th class="text-right">Mínimo (h)</th>
                                <th class="text-right">Validade</th>
                                <th class="text-right">Convocados</th>
                                <th>EPIs previstos</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($trainings as $training)
                                <tr>
                                    <td class="font-medium text-slate-900">{{ $training->norm }}</td>
                                    <td class="whitespace-normal">{{ $training->title }}</td>
                                    <td>{{ $training->status }}</td>
                                    <td class="whitespace-normal">{{ $training->instructor->name ?? '—' }}</td>
                                    <td class="text-right">{{ $training->class_min }}</td>
                                    <td class="text-right">{{ $training->min_hours }}</td>
                                    <td class="text-right">{{ $training->validity_months }} {{ $training->validity_months === 1 ? 'mês' : 'meses' }}</td>
                                    <td class="text-right">{{ $training->employees->count() }}</td>
                                    <td class="whitespace-normal">{{ $training->epis->isNotEmpty() ? $training->epis->pluck('name')->implode(', ') : '—' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="9" class="py-10 text-center text-slate-400">Nenhum treinamento no escopo.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            {{-- Assinaturas --}}
            <footer class="print-avoid-break mt-4 border-t border-slate-200 pt-6">
                <div class="grid gap-10 text-center text-xs text-slate-500 sm:grid-cols-2">
                    <div class="border-t border-slate-400 pt-2">
                        <p class="font-semibold text-slate-700">{{ $issuedBy }}</p>
                        <p>Responsável pela emissão</p>
                    </div>
                    <div class="border-t border-slate-400 pt-2">
                        <p class="font-semibold text-slate-700">&nbsp;</p>
                        <p>Responsável pela segurança do trabalho</p>
                    </div>
                </div>
                <p class="mt-6 text-center text-[11px] text-slate-400">
                    Documento {{ $documentCode }}, gerado pelo sistema Gestão SST em {{ $issuedAt->format('d/m/Y \à\s H:i') }}
                    a partir dos registros de treinamentos, presenças e certificados naquele momento.
                </p>
            </footer>
        </article>
    </main>
</x-layouts.base>
