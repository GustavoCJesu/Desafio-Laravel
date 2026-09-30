@php
    $statusBadges = ['Agendado' => 'badge-info', 'Concluído' => 'badge-success', 'Cancelado' => 'badge-danger'];
    $selectedEpis = $training->epis->pluck('id')->all();
    $selectedEmployees = $training->employees->pluck('id')->all();
@endphp

<x-layouts.app title="Editar aula" :subtitle="$training->norm.' · '.$training->title" icon="graduation-cap">
    <x-slot:actions>
        <a href="{{ route('training.index') }}" class="btn btn-secondary">
            <i data-lucide="arrow-left"></i><span class="hidden sm:inline">Voltar</span>
        </a>
    </x-slot:actions>

    {{-- Protótipo visual: os formulários ainda não salvam --}}
    <div class="mx-auto grid max-w-7xl items-start gap-6 xl:grid-cols-3">
        <div class="flex flex-col gap-6 xl:col-span-2">
            {{-- Dados da aula --}}
            <form class="card" onsubmit="event.preventDefault();">
                <div class="card-header">
                    <div class="flex items-center gap-3">
                        <div class="bg-gradient-primary flex size-10 shrink-0 flex-col items-center justify-center rounded-xl text-white">
                            <span class="text-[9px] leading-none opacity-80">NR</span>
                            <span class="text-sm leading-tight font-bold">{{ substr($training->norm, 3) }}</span>
                        </div>
                        <div>
                            <h2 class="card-title">Dados da aula</h2>
                            <p class="text-xs text-slate-500">Instrutor, agenda e carga horária</p>
                        </div>
                    </div>
                    <span class="badge {{ $statusBadges[$training->status] ?? 'badge-neutral' }}">{{ $training->status }}</span>
                </div>

                <div class="card-body grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="form-label" for="norm">Norma</label>
                        <input id="norm" name="norm" maxlength="10" class="form-input" type="text" value="{{ $training->norm }}" />
                    </div>
                    <div>
                        <label class="form-label" for="title">Título</label>
                        <input id="title" name="title" class="form-input" type="text" value="{{ $training->title }}" />
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
                        <label class="form-label" for="scheduled">Data e hora</label>
                        <input id="scheduled" name="scheduled" class="form-input" type="datetime-local"
                            value="{{ $training->scheduled->format('Y-m-d\TH:i') }}" />
                    </div>
                    <div>
                        <label class="form-label" for="validity_dt">Validade do certificado</label>
                        <input id="validity_dt" name="validity_dt" class="form-input" type="date"
                            value="{{ $training->validity_dt->format('Y-m-d') }}" />
                    </div>
                    <div>
                        <label class="form-label" for="class_min">Carga horária (h)</label>
                        <input id="class_min" name="class_min" min="1" class="form-input" type="number" value="{{ $training->class_min }}" />
                    </div>
                    <div>
                        <label class="form-label" for="class_amount">Qtd. de aulas</label>
                        <input id="class_amount" name="class_amount" min="1" class="form-input" type="number" value="{{ $training->class_amount }}" />
                    </div>
                    <div>
                        <label class="form-label" for="capacity">Vagas</label>
                        <input id="capacity" name="capacity" min="1" class="form-input" type="number" value="{{ $training->capacity }}" />
                    </div>
                    <div>
                        <label class="form-label" for="location">Local</label>
                        <input id="location" name="location" class="form-input" type="text" value="{{ $training->location }}" />
                    </div>
                </div>

                <div class="flex justify-end gap-2 border-t border-slate-100 bg-slate-50/60 px-5 py-4">
                    <a href="{{ route('training.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary"><i data-lucide="save"></i>Salvar aula</button>
                </div>
            </form>

            {{-- Participantes --}}
            <form class="card overflow-hidden" onsubmit="event.preventDefault();">
                <div class="card-header">
                    <div class="flex items-center gap-3">
                        <div class="flex size-10 items-center justify-center rounded-full bg-indigo-100 text-accent-600">
                            <i data-lucide="users" class="size-5"></i>
                        </div>
                        <div>
                            <h2 class="card-title">Participantes</h2>
                            <p class="text-xs text-slate-500">
                                <span id="participant-count">{{ count($selectedEmployees) }}</span>/{{ $training->capacity }} vagas preenchidas
                            </p>
                        </div>
                    </div>
                    <div class="relative w-48 sm:w-64">
                        <i data-lucide="search" class="pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2 text-slate-400"></i>
                        <input type="search" oninput="filterList('participant-list', this.value)" class="form-input pl-9"
                            placeholder="Buscar funcionário...">
                    </div>
                </div>

                <ul id="participant-list" class="max-h-96 divide-y divide-slate-100 overflow-y-auto">
                    @forelse ($employees as $employee)
                        <li data-search="{{ mb_strtolower($employee->name.' '.$employee->registration) }}">
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
                    <button type="submit" class="btn btn-primary"><i data-lucide="save"></i>Salvar participantes</button>
                </div>
            </form>
        </div>

        <div class="flex flex-col gap-6">
            {{-- EPIs vinculados --}}
            <form class="card overflow-hidden" onsubmit="event.preventDefault();">
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
                        <i data-lucide="search" class="pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2 text-slate-400"></i>
                        <input type="search" oninput="filterList('epi-list', this.value)" class="form-input pl-9"
                            placeholder="Buscar EPI ou CA...">
                    </div>
                </div>

                <ul id="epi-list" class="max-h-80 divide-y divide-slate-100 overflow-y-auto">
                    @forelse ($epis as $epi)
                        <li data-search="{{ mb_strtolower($epi->name.' '.$epi->ca) }}">
                            <label class="flex cursor-pointer items-center gap-3 px-5 py-2.5 hover:bg-slate-50">
                                <input type="checkbox" name="epis[]" value="{{ $epi->id }}" class="form-checkbox"
                                    @checked(in_array($epi->id, $selectedEpis))>
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm text-slate-800">{{ $epi->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $epi->category->name ?? 'Sem categoria' }}</p>
                                </div>
                                <span class="rounded-md bg-slate-100 px-2 py-0.5 font-mono text-xs text-slate-600">{{ $epi->ca }}</span>
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

            {{-- Datas das aulas --}}
            <div class="card overflow-hidden">
                <div class="card-header">
                    <div class="flex items-center gap-3">
                        <div class="flex size-10 items-center justify-center rounded-full bg-emerald-100 text-emerald-700">
                            <i data-lucide="calendar-days" class="size-5"></i>
                        </div>
                        <div>
                            <h2 class="card-title">Datas das aulas</h2>
                            <p class="text-xs text-slate-500">{{ $training->classes->count() }} de {{ $training->class_amount }} cadastradas</p>
                        </div>
                    </div>
                </div>

                <ul class="divide-y divide-slate-100">
                    @forelse ($training->classes as $class)
                        <li class="flex items-center justify-between px-5 py-2.5 text-sm text-slate-700">
                            <span class="flex items-center gap-2">
                                <i data-lucide="calendar" class="size-4 text-slate-400"></i>{{ $class->class_dt->format('d/m/Y') }}
                            </span>
                            <button type="button" class="btn btn-danger-soft btn-sm" title="Remover">
                                <i data-lucide="trash-2"></i>
                            </button>
                        </li>
                    @empty
                        <li class="px-5 py-8 text-center text-sm text-slate-500">Nenhuma data cadastrada ainda.</li>
                    @endforelse
                </ul>

                <form class="flex gap-2 border-t border-slate-100 bg-slate-50/60 px-5 py-4" onsubmit="event.preventDefault();">
                    <input name="class_dt" type="date" class="form-input flex-1" />
                    <button type="submit" class="btn btn-primary" title="Adicionar data">
                        <i data-lucide="plus"></i>
                    </button>
                </form>
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
