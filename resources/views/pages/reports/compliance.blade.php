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
    $backUrl = auth()->user()->can('employees.view') ? route('employees.index') : route('certificate.index');
@endphp

<x-layouts.base title="Relatório de conformidade">
    <div class="no-print sticky top-0 z-10 border-b border-slate-200 bg-white/90 backdrop-blur">
        <div class="mx-auto flex max-w-6xl items-center gap-3 px-4 py-3 sm:px-8">
            <a id="report-back" href="{{ $backUrl }}" class="icon-btn" title="Voltar" aria-label="Voltar">
                <i data-lucide="arrow-left"></i>
            </a>

            <div class="flex min-w-0 flex-1 items-center gap-3">
                <div class="hidden size-10 shrink-0 items-center justify-center rounded-xl bg-brand-100 text-brand-700 sm:flex">
                    <i data-lucide="file-check-2" class="size-5"></i>
                </div>
                <div class="min-w-0">
                    <h1 class="truncate text-base font-bold text-slate-900 sm:text-lg">Relatório de conformidade</h1>
                    <p class="truncate text-xs text-slate-500 sm:text-sm">Escolha os filtros e imprima ou exporte o documento</p>
                </div>
            </div>

            <div class="flex shrink-0 items-center gap-2">
                @can('reports.export')
                    <a href="{{ route('report.compliance.export', $exportQuery) }}" class="btn btn-secondary">
                        <i data-lucide="download"></i><span class="hidden sm:inline">Exportar CSV</span>
                    </a>
                @endcan
                <button type="button" onclick="window.print()" class="btn btn-primary">
                    <i data-lucide="printer"></i><span class="hidden sm:inline">Imprimir</span>
                </button>
            </div>
        </div>
    </div>

    <form method="GET" action="{{ route('report.compliance') }}" class="no-print mx-auto mt-6 w-full max-w-6xl px-4 sm:px-8">
        <div class="card">
            <div class="grid items-end gap-4 p-4 sm:grid-cols-2 lg:grid-cols-[1fr_1fr_auto_auto]">
                <div>
                    <label class="form-label" for="filter_sector">Setor</label>
                    <select id="filter_sector" name="sector_id" class="form-input">
                        <option value="">Todos os setores</option>
                        @foreach ($sectors as $sector)
                            <option value="{{ $sector->id }}" @selected((int) ($filters['sector_id'] ?? 0) === $sector->id)>{{ $sector->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label" for="filter_norm">Norma</label>
                    <select id="filter_norm" name="norm" class="form-input">
                        <option value="">Todas as normas</option>
                        @foreach ($norms as $norm)
                            <option value="{{ $norm }}" @selected(($filters['norm'] ?? null) === $norm)>{{ $norm }}</option>
                        @endforeach
                    </select>
                </div>
                <label class="flex h-10 items-center gap-2 text-sm text-slate-700">
                    <input type="checkbox" name="only_pending" value="1" class="size-4 accent-brand-700"
                        @checked($filters['only_pending'] ?? false)>
                    Somente pendências
                </label>
                <div class="flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i data-lucide="filter"></i>Aplicar
                    </button>
                    <a href="{{ route('report.compliance') }}" class="btn btn-secondary" title="Limpar filtros">
                        <i data-lucide="rotate-ccw"></i><span class="sr-only">Limpar filtros</span>
                    </a>
                </div>
            </div>
        </div>
    </form>

    <main class="mx-auto my-6 w-full max-w-6xl px-4 sm:px-8 print:my-0 print:max-w-none print:px-0">
        <article class="flex flex-col gap-8 rounded-xl bg-white p-6 shadow-card ring-1 ring-slate-200 sm:p-10 print:rounded-none print:p-0 print:shadow-none print:ring-0">
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

            <section class="print-avoid-break">
                <h2 class="text-sm font-semibold tracking-wide text-slate-900 uppercase">1. Escopo</h2>
                <dl class="mt-3 grid gap-x-8 gap-y-2 text-sm sm:grid-cols-2">
                    <div class="flex gap-2"><dt class="text-slate-500">Data de referência:</dt><dd class="font-medium">{{ $issuedAt->format('d/m/Y') }}</dd></div>
                    <div class="flex gap-2"><dt class="text-slate-500">Setor:</dt><dd class="font-medium">{{ $sectorName ?? 'Todos' }}</dd></div>
                    <div class="flex gap-2"><dt class="text-slate-500">Norma:</dt><dd class="font-medium">{{ $filters['norm'] ?? 'Todas' }}</dd></div>
                    <div class="flex gap-2"><dt class="text-slate-500">Listagem:</dt><dd class="font-medium">{{ ($filters['only_pending'] ?? false) ? 'Somente pendências' : 'Todos os registros' }}</dd></div>
                </dl>
                <p class="mt-3 text-xs leading-relaxed text-slate-500">
                    A <b>cobertura</b> considera todos os funcionários <b>ativos</b> do escopo e informa quantos têm certificado ainda válido,
                    inclusive os que nunca foram convocados. A <b>conformidade das convocações</b> avalia os funcionários ativos convocados
                    para treinamentos não cancelados, uma vez por norma, pelo certificado mais favorável. Contam como conformes os certificados
                    <b>Válidos</b> e <b>A vencer</b> (vencimento em até 60 dias). O sistema ainda não registra quais normas cada cargo exige,
                    por isso quem nunca foi convocado aparece na cobertura, mas não como pendência individual. Os indicadores valem para todo
                    o escopo, mesmo quando a listagem mostra só as pendências.
                </p>
            </section>

            <section class="print-avoid-break">
                <h2 class="text-sm font-semibold tracking-wide text-slate-900 uppercase">2. Cobertura da força de trabalho</h2>
                <div class="mt-3 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <x-ui.stat-card label="Funcionários ativos" value="{{ number_format($coverage['employees'], 0, ',', '.') }}" icon="users"
                        hint="{{ $sectorName ?? 'Todos os setores' }}" />
                    <x-ui.stat-card label="Com certificado válido" value="{{ number_format($coverage['covered'], 0, ',', '.') }}" icon="shield-check"
                        :tone="$coverage['rate'] >= 90 ? 'success' : 'warning'" hint="{{ $coverage['rate'] }}% dos ativos" />
                    <x-ui.stat-card label="Convocados sem certificado válido" value="{{ number_format($coverage['convoked_without_certificate'], 0, ',', '.') }}" icon="clock"
                        tone="warning" hint="Treinamento pendente ou vencido" />
                    <x-ui.stat-card label="Sem treinamento registrado" value="{{ number_format($coverage['untrained'], 0, ',', '.') }}" icon="triangle-alert"
                        tone="danger" hint="Nunca convocados" />
                </div>
            </section>

            <section class="print-avoid-break">
                <h2 class="text-sm font-semibold tracking-wide text-slate-900 uppercase">3. Conformidade das convocações</h2>
                <div class="mt-3 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <x-ui.stat-card label="Índice de conformidade" value="{{ $summary['rate'] }}%" icon="shield-check"
                        :tone="$summary['rate'] >= 90 ? 'success' : 'warning'" hint="{{ $summary['compliant'] }} de {{ $summary['requirements'] }} convocações" />
                    <x-ui.stat-card label="Funcionários convocados" value="{{ $summary['employees'] }}" icon="users"
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

            <section class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_minmax(0,1fr)]">
                <div class="print-avoid-break min-w-0">
                    <h2 class="text-sm font-semibold tracking-wide text-slate-900 uppercase">4. Convocações por norma</h2>
                    <div class="mt-3 overflow-x-auto print:overflow-visible">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Norma</th>
                                    <th class="text-right">Convocações</th>
                                    <th class="text-right">Conformes</th>
                                    <th class="text-right">Índice</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($byNorm as $name => $group)
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
                </div>

                <div class="print-avoid-break min-w-0">
                    <h2 class="text-sm font-semibold tracking-wide text-slate-900 uppercase">5. Cobertura por setor</h2>
                    <div class="mt-3 overflow-x-auto print:overflow-visible">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Setor</th>
                                    <th class="text-right">Ativos</th>
                                    <th class="text-right whitespace-normal">Com certificado</th>
                                    <th class="text-right">Cobertura</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($coverageBySector as $sector)
                                    <tr>
                                        <td class="font-medium whitespace-normal text-slate-900">{{ $sector['name'] }}</td>
                                        <td class="text-right">{{ number_format($sector['employees'], 0, ',', '.') }}</td>
                                        <td class="text-right">{{ number_format($sector['covered'], 0, ',', '.') }}</td>
                                        <td class="text-right font-semibold {{ $sector['rate'] >= 90 ? 'text-emerald-700' : 'text-amber-700' }}">{{ $sector['rate'] }}%</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="py-6 text-center text-slate-400">Sem setores no escopo.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section>
                <h2 class="text-sm font-semibold tracking-wide text-slate-900 uppercase">6. Registro de evidências por funcionário</h2>
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

            <section>
                <h2 class="text-sm font-semibold tracking-wide text-slate-900 uppercase">7. Treinamentos considerados</h2>
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
                                    <td class="font-medium text-slate-900">{{ $training->norm ?? '—' }}</td>
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

    <script>
        (function () {
            const back = document.getElementById('report-back');
            const key = 'complianceReportOrigin';

            try {
                const referrer = document.referrer;
                const isOtherPage = referrer.startsWith(location.origin) && !referrer.startsWith(location.origin + location.pathname);

                if (isOtherPage) {
                    sessionStorage.setItem(key, referrer);
                }

                back.href = sessionStorage.getItem(key) || back.href;
            } catch (error) {
            }
        })();
    </script>
</x-layouts.base>
