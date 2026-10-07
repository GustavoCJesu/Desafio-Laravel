@php
    $statusBadges = ['Agendado' => 'badge-info', 'Concluído' => 'badge-success', 'Cancelado' => 'badge-danger'];
    $selectedEpis = $training->epis->pluck('id')->all();
    $selectedEmployees = $training->employees->pluck('id')->all();

    // Dados mockados do card de certificados (a regra real virá do backend)
    $certificatesIssued = false;
    $canIssueCertificates = $training->status === 'Concluído';
    // $certificateCandidates = [
    //     ['name' => 'Ana Paula Souza', 'registration' => '4821-3', 'hours' => 8],
    //     ['name' => 'Bruno Costa', 'registration' => '1932-7', 'hours' => 8],
    //     ['name' => 'Juliana Martins', 'registration' => '7710-1', 'hours' => 6],
    //     ['name' => 'Marcos Oliveira', 'registration' => '3345-9', 'hours' => 2],
    //     ['name' => 'Patrícia Lima', 'registration' => '0584-2', 'hours' => 0],
    // ]
@endphp
<x-layouts.app title="Editar aula" :subtitle="$training->norm . ' · ' . $training->title" icon="graduation-cap">
    <x-slot:modals>
        <x-ui.modal id="issueCertificatesModal" title="Emitir certificados"
            subtitle="Esta ação gera os certificados dos funcionários elegíveis." icon="award">
            <div class="px-6 py-5 text-sm text-slate-600">
                <p>
                    Serão emitidos <b class="text-slate-900">{{ count($certificateCandidates) - count(array_filter($certificateCandidates, function ($candidate) use($training) {
                                    return $candidate['hours'] < $training->min_hours;
                                })) }}</b> certificados para
                    <b class="text-slate-900">{{ $training->norm }} · {{ $training->title }}</b>.
                </p>
                <p class="mt-2">
                    {{count(array_filter($certificateCandidates, function ($candidate) use($training) {
                                    return $candidate['hours'] < $training->min_hours;
                                })) }} funcionário(s) não atingiram a
                    carga horária
                    mínima de {{ $training->min_hours }}h e não receberão o certificado.
                </p>
            </div>
            <div class="flex justify-end gap-2 border-t border-slate-100 bg-slate-50 px-6 py-4">
                <button type="button" class="btn btn-secondary"
                    onclick="toggleModal('issueCertificatesModal')">Cancelar</button>
                <form action="{{ route('certificate.store', $session = $training->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary" onclick="toggleModal('issueCertificatesModal')">
                        <i data-lucide="check"></i>Confirmar emissão
                    </button>
                </form>
            </div>
        </x-ui.modal>
    </x-slot:modals>

    <x-slot:actions>
        <a href="{{ route('training.index') }}" class="btn btn-secondary">
            <i data-lucide="arrow-left"></i><span class="hidden sm:inline">Voltar</span>
        </a>
    </x-slot:actions>

    <div class="mx-auto grid max-w-7xl items-start gap-6 xl:grid-cols-3">
        <div class="flex flex-col gap-6 xl:col-span-2">
            {{-- Dados da aula --}}
            <form class="card" method="POST"
                action="{{ route('training.update', [($sessionTraning = $training->id)]) }}">
                @csrf
                <div class="card-header">
                    <div class="flex items-center gap-3">
                        <div
                            class="bg-gradient-primary flex size-10 shrink-0 flex-col items-center justify-center rounded-xl text-white">
                            <span class="text-[9px] leading-none opacity-80">NR</span>
                            <span class="text-sm leading-tight font-bold">{{ substr($training->norm, 3) }}</span>
                        </div>
                        <div>
                            <h2 class="card-title">Dados da aula</h2>
                            <p class="text-xs text-slate-500">Instrutor, agenda e carga horária</p>
                        </div>
                    </div>
                    <span
                        class="badge {{ $statusBadges[$training->status] ?? 'badge-neutral' }}">{{ $training->status }}</span>
                </div>

                <div class="card-body grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="form-label" for="norm">Norma</label>
                        <input id="norm" name="norm" maxlength="10" class="form-input" type="text"
                            value="{{ $training->norm }}" />
                    </div>
                    <div>
                        <label class="form-label" for="title">Título</label>
                        <input id="title" name="title" class="form-input" type="text"
                            value="{{ $training->title }}" />
                    </div>
                    <div class="sm:col-span-2">
                        <label class="form-label" for="description">Descrição</label>
                        <textarea id="description" name="description" rows="3" class="form-input">{{ $training->description }}</textarea>
                    </div>
                    <div>
                        <label class="form-label" for="instructor_id">Instrutor</label>
                        <select id="instructor_id" name="instructor_id" class="form-input">
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}" @selected($training->instructor_id === $employee->id)>
                                    {{ $employee->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label" for="status">Status</label>
                        <select id="status" name="status" class="form-input">
                            @foreach (array_keys($statusBadges) as $status)
                                <option @selected($training->status === $status)>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label" for="validity_months">Validade do certificado (meses)</label>
                        <input id="validity_months" name="validity_months" min="1" class="form-input" type="number"
                            value="{{ $training->validity_months }}" />
                    </div>
                    <div>
                        <label class="form-label" for="class_min">Carga horária (h)</label>
                        <input id="class_min" name="class_min" min="1" class="form-input" type="number"
                            value="{{ $training->class_min }}" />
                    </div>
                    <div>
                        <label class="form-label" for="min_hours">Carga horária mínima (h)</label>
                        <input id="min_hours" name="min_hours" min="1" class="form-input" type="number"
                            value="{{ $training->min_hours }}" />
                    </div>
                    <div>
                        <label class="form-label" for="class_amount">Qtd. de aulas</label>
                        <input id="class_amount" name="class_amount" min="1" class="form-input" type="number"
                            value="{{ $training->class_amount }}" />
                    </div>
                    <div>
                        <label class="form-label" for="capacity">Vagas</label>
                        <input id="capacity" name="capacity" min="1" class="form-input" type="number"
                            value="{{ $training->capacity }}" />
                    </div>
                    <div>
                        <label class="form-label" for="location">Local</label>
                        <input id="location" name="location" class="form-input" type="text"
                            value="{{ $training->location }}" />
                    </div>
                </div>

                <div class="flex justify-end gap-2 border-t border-slate-100 bg-slate-50/60 px-5 py-4">
                    <a href="{{ route('training.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary"><i data-lucide="save"></i>Salvar aula</button>
                </div>
            </form>

            {{-- Participantes --}}
            <form class="card overflow-hidden" method="POST"
                action="{{ route('training.vincemployee', [($sessionTraning = $training->id)]) }}">
                <div class="card-header">
                    <div class="flex items-center gap-3">
                        <div
                            class="flex size-10 items-center justify-center rounded-full bg-indigo-100 text-accent-600">
                            <i data-lucide="users" class="size-5"></i>
                        </div>
                        <div>
                            <h2 class="card-title">Participantes</h2>
                            <p class="text-xs text-slate-500">
                                <span
                                    id="participant-count">{{ count($selectedEmployees) }}</span>/{{ $training->capacity }}
                                vagas preenchidas
                            </p>
                        </div>
                    </div>
                    <div class="relative w-48 sm:w-64">
                        <i data-lucide="search"
                            class="pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2 text-slate-400"></i>
                        <input type="search" oninput="filterList('participant-list', this.value)"
                            class="form-input pl-9" placeholder="Buscar funcionário...">
                    </div>
                </div>

                <ul id="participant-list" class="max-h-96 min-h-96 divide-y divide-slate-100 overflow-y-auto">
                    @forelse ($employees as $employee)
                        <li data-search="{{ mb_strtolower($employee->name . ' ' . $employee->registration) }}">
                            <label class="flex cursor-pointer items-center gap-3 px-5 py-3 hover:bg-slate-50">
                                <input type="checkbox" name="employees[]" value="{{ $employee->id }}"
                                    class="form-checkbox size-5" onchange="updateParticipantCount()"
                                    @checked(in_array($employee->id, $selectedEmployees))>
                                <x-ui.avatar :name="$employee->name" class="size-9 text-xs" />
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-medium text-slate-900">{{ $employee->name }}</p>
                                    <p class="text-xs text-slate-500">
                                        <span class="font-mono">{{ $employee->registration }}</span>
                                        · {{ $employee->sector->name ?? 'Sem setor' }}
                                    </p>
                                </div>
                            </label>
                        </li>
                    @empty
                        <li class="px-5 py-10 text-center text-sm text-slate-500">Nenhum funcionário ativo.</li>
                    @endforelse
                </ul>

                <div class="flex justify-end gap-2 border-t border-slate-100 bg-slate-50/60 px-5 py-4">
                    <button type="submit" class="btn btn-primary"><i data-lucide="save"></i>Salvar
                        participantes</button>
                </div>
            </form>
        </div>

        <div class="flex flex-col gap-6">
            {{-- EPIs vinculados --}}
            <form class="card overflow-hidden" method="POST"
                action="{{ route('training.vincepi', [($sessionTraining = $training->id)]) }}">
                @csrf
                <div class="card-header">
                    <div class="flex items-center gap-3">
                        <div class="flex size-10 items-center justify-center rounded-full bg-amber-100 text-amber-700">
                            <i data-lucide="hard-hat" class="size-5"></i>
                        </div>
                        <div>
                            <h2 class="card-title">EPIs da aula</h2>
                            <p class="text-xs text-slate-500">Equipamentos abordados no treinamento</p>
                        </div>
                    </div>
                </div>

                <div class="border-b border-slate-100 px-5 py-3">
                    <div class="relative">
                        <i data-lucide="search"
                            class="pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2 text-slate-400"></i>
                        <input type="search" oninput="filterList('epi-list', this.value)" class="form-input pl-9"
                            placeholder="Buscar EPI ou CA...">
                    </div>
                </div>

                <ul id="epi-list" class="max-h-80 min-h-80 divide-y divide-slate-100 overflow-y-auto">
                    @forelse ($epis as $epi)
                        <li data-search="{{ mb_strtolower($epi->name . ' ' . $epi->ca) }}">
                            <label class="flex cursor-pointer items-center gap-3 px-5 py-2.5 hover:bg-slate-50">
                                <input type="checkbox" name="epis[]" value="{{ $epi->id }}"
                                    class="form-checkbox" @checked(in_array($epi->id, $selectedEpis))>
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm text-slate-800">{{ $epi->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $epi->category->name ?? 'Sem categoria' }}
                                    </p>
                                </div>
                                <span
                                    class="rounded-md bg-slate-100 px-2 py-0.5 font-mono text-xs text-slate-600">{{ $epi->ca }}</span>
                            </label>
                        </li>
                    @empty
                        <li class="px-5 py-10 text-center text-sm text-slate-500">Nenhum EPI ativo.</li>
                    @endforelse
                </ul>

                <div class="flex justify-end border-t border-slate-100 bg-slate-50/60 px-5 py-4">
                    <button type="submit" class="btn btn-primary"><i data-lucide="save"></i>Salvar EPIs</button>
                </div>
            </form>

            {{-- Aulas agendadas --}}
            <div class="card overflow-hidden">
                <div class="card-header">
                    <div class="flex items-center gap-3">
                        <div
                            class="flex size-10 items-center justify-center rounded-full bg-emerald-100 text-emerald-700">
                            <i data-lucide="calendar-days" class="size-5"></i>
                        </div>
                        <div>
                            <h2 class="card-title">Aulas agendadas</h2>
                            <p class="text-xs text-slate-500">{{ $training->classes->count() }} de
                                {{ $training->class_amount }} cadastradas</p>
                        </div>
                    </div>
                </div>

                <ul class="divide-y divide-slate-100">
                    @forelse ($training->classes as $class)
                        <li class="flex items-center justify-between px-5 py-2.5 text-sm text-slate-700">
                            <span class="flex items-center gap-2">
                                <i data-lucide="calendar"
                                    class="size-4 text-slate-400"></i>{{ $class->class_dt->format('d/m/Y \à\s H:i') }}
                                <span class="text-xs text-slate-500">·
                                    {{ rtrim(rtrim(number_format($class->duration_hours, 2, ',', ''), '0'), ',') }}h</span>
                                <span
                                    class="badge {{ $statusBadges[$class->status] ?? 'badge-info' }}">{{ $class->status }}</span>
                            </span>
                            <div class="flex items-center gap-1">
                                @if ($class->status !== 'Concluído')
                                    <form action="{{ route('training.completeclass', [$training->id, $class->id]) }}"
                                        method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-secondary btn-sm"
                                            title="Concluir aula">
                                            <i data-lucide="check"></i>
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('training.deleteclass', [$training->id, $class->id]) }}"
                                    method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger-soft btn-sm" title="Remover">
                                        <i data-lucide="trash-2"></i>
                                    </button>
                                </form>
                            </div>
                        </li>
                    @empty
                        <li class="px-5 py-8 text-center text-sm text-slate-500">Nenhuma aula agendada ainda.</li>
                    @endforelse
                </ul>

                <form class="flex gap-2 border-t border-slate-100 bg-slate-50/60 px-5 py-4" method="POST"
                    action="{{ route('training.createclass', [($sessionTraining = $training->id)]) }}">
                    <input name="class_dt" type="datetime-local" class="form-input flex-1" required />
                    <input name="duration_hours" type="number" step="0.25" min="0.25" max="24"
                        class="form-input w-28"
                        value="{{ $training->class_amount > 0 ? round($training->class_min / $training->class_amount, 2) : '' }}"
                        placeholder="Horas" title="Duração da aula em horas" required />
                    <button type="submit" class="btn btn-primary" title="Agendar aula">
                        <i data-lucide="plus"></i>
                    </button>
                </form>
            </div>

            {{-- Certificados --}}
            <div id="certificates" class="card overflow-hidden">
                <div class="card-header">
                    <div class="flex items-center gap-3">
                        <div
                            class="flex size-10 items-center justify-center rounded-full bg-emerald-100 text-emerald-700">
                            <i data-lucide="award" class="size-5"></i>
                        </div>
                        <div>
                            <h2 class="card-title">Certificados</h2>
                            <p class="text-xs text-slate-500">
                                {{ count($certificateCandidates) }} elegíveis ·
                                {{ count(array_filter($certificateCandidates, function ($candidate) use($training) {
                                    return $candidate['hours'] < $training->min_hours;
                                })) }} reprovados por carga
                                horária
                            </p>
                        </div>
                    </div>
                    @if ($certificatesIssued)
                        <span class="badge badge-success"><i data-lucide="badge-check"
                                class="size-3.5"></i>Certificados emitidos</span>
                    @else
                        @can('certificates.allow')
                            <button type="button" class="btn btn-primary"
                                onclick="toggleModal('issueCertificatesModal')" @disabled(!$canIssueCertificates)>
                                <i data-lucide="award"></i>Emitir certificados
                            </button>
                        @endcan
                    @endif
                </div>

                @unless ($canIssueCertificates)
                    <div
                        class="flex items-center gap-2 border-b border-slate-100 bg-amber-50 px-5 py-3 text-sm text-amber-800">
                        <i data-lucide="info" class="size-4 shrink-0"></i>
                        Disponível quando todas as aulas forem concluídas.
                    </div>
                @endunless

                <ul class="max-h-72 divide-y divide-slate-100 overflow-y-auto">
                    @foreach ($certificateCandidates as $candidate)
                        @php($isEligible = $candidate['hours'] >= $training->min_hours)
                        <li class="flex items-center gap-3 px-5 py-3">
                            <x-ui.avatar :name="$candidate['name']" class="size-9 text-xs" />
                            <div class="flex-1">
                                <p class="text-sm font-medium text-slate-900">{{ $candidate['name'] }}</p>
                                <p class="font-mono text-xs text-slate-500">{{ $candidate['registration'] }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-slate-500">
                                    <span class="font-semibold text-slate-700">{{ $candidate['hours'] }}h</span>
                                    de {{ $training->min_hours }}h mínimas
                                </p>
                                <span class="badge {{ $isEligible ? 'badge-success' : 'badge-danger' }}">
                                    {{ $isEligible ? 'Elegível' : 'Reprovado por carga horária' }}
                                </span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <script>
        function filterList(listId, value) {
            const term = value.trim().toLowerCase();

            document.querySelectorAll(`#${listId} > li[data-search]`).forEach((item) => {
                item.classList.toggle('hidden', !item.dataset.search.includes(term));
            });
        }

        function updateParticipantCount() {
            document.getElementById('participant-count').textContent =
                document.querySelectorAll('#participant-list input:checked').length;
        }
    </script>
</x-layouts.app>
