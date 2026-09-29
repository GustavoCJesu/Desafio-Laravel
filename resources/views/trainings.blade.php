@php
    // Dados estáticos para prototipação da interface
    $trainings = [
        ['id' => 1, 'nr' => 'NR-35', 'title' => 'Trabalho em Altura', 'instructor' => 'Carlos Mendes', 'date' => '02/10/2026', 'time' => '08:00', 'hours' => 8, 'enrolled' => 18, 'capacity' => 20, 'status' => 'Agendado', 'location' => 'Sala de treinamento 1'],
        ['id' => 2, 'nr' => 'NR-06', 'title' => 'Uso correto de EPI', 'instructor' => 'Fernanda Rocha', 'date' => '05/10/2026', 'time' => '14:00', 'hours' => 4, 'enrolled' => 25, 'capacity' => 30, 'status' => 'Agendado', 'location' => 'Auditório'],
        ['id' => 3, 'nr' => 'NR-10', 'title' => 'Segurança em Eletricidade', 'instructor' => 'Ricardo Alves', 'date' => '09/10/2026', 'time' => '08:30', 'hours' => 40, 'enrolled' => 12, 'capacity' => 15, 'status' => 'Agendado', 'location' => 'Laboratório elétrico'],
        ['id' => 4, 'nr' => 'NR-33', 'title' => 'Espaço Confinado', 'instructor' => 'Carlos Mendes', 'date' => '14/10/2026', 'time' => '09:00', 'hours' => 16, 'enrolled' => 8, 'capacity' => 12, 'status' => 'Agendado', 'location' => 'Área externa'],
        ['id' => 5, 'nr' => 'NR-12', 'title' => 'Máquinas e Equipamentos', 'instructor' => 'Juliana Prado', 'date' => '18/09/2026', 'time' => '08:00', 'hours' => 8, 'enrolled' => 22, 'capacity' => 22, 'status' => 'Concluído', 'location' => 'Galpão B'],
        ['id' => 6, 'nr' => 'NR-23', 'title' => 'Proteção contra Incêndios', 'instructor' => 'Fernanda Rocha', 'date' => '10/09/2026', 'time' => '13:30', 'hours' => 4, 'enrolled' => 30, 'capacity' => 30, 'status' => 'Concluído', 'location' => 'Pátio central'],
        ['id' => 7, 'nr' => 'NR-11', 'title' => 'Operação de Empilhadeira', 'instructor' => 'Ricardo Alves', 'date' => '28/08/2026', 'time' => '08:00', 'hours' => 16, 'enrolled' => 6, 'capacity' => 10, 'status' => 'Cancelado', 'location' => 'Depósito'],
    ];

    $statusBadges = ['Agendado' => 'badge-info', 'Concluído' => 'badge-success', 'Cancelado' => 'badge-danger'];

    $attendees = [
        ['name' => 'Ana Paula Souza', 'registration' => '4821-3', 'present' => true],
        ['name' => 'Bruno Costa', 'registration' => '1932-7', 'present' => true],
        ['name' => 'Juliana Martins', 'registration' => '7710-1', 'present' => false],
        ['name' => 'Marcos Oliveira', 'registration' => '3345-9', 'present' => true],
        ['name' => 'Patrícia Lima', 'registration' => '0584-2', 'present' => true],
        ['name' => 'Lucas Ferreira', 'registration' => '6671-5', 'present' => false],
    ];
@endphp

<x-app-layout title="Aulas" subtitle="Treinamentos e reciclagens das Normas Regulamentadoras" icon="graduation-cap">
    <x-slot:modals>
        {{-- Novo agendamento (protótipo visual) --}}
        <x-modal id="newTrainingModal" title="Agendar aula" subtitle="Preencha os dados do treinamento." icon="calendar-plus" size="max-w-2xl">
            <form onsubmit="event.preventDefault(); toggleModal('newTrainingModal');">
                <div class="grid gap-4 px-6 py-5 sm:grid-cols-2">
                    <div>
                        <label class="form-label" for="training_nr">Norma</label>
                        <select id="training_nr" class="form-input">
                            @foreach (['NR-06', 'NR-10', 'NR-11', 'NR-12', 'NR-23', 'NR-33', 'NR-35'] as $nr)
                                <option>{{ $nr }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label" for="training_title">Título</label>
                        <input id="training_title" class="form-input" placeholder="Trabalho em Altura" type="text" />
                    </div>
                    <div class="sm:col-span-2">
                        <label class="form-label" for="training_description">Descrição</label>
                        <textarea id="training_description" rows="3" class="form-input" placeholder="Conteúdo programático da aula..."></textarea>
                    </div>
                    <div>
                        <label class="form-label" for="training_instructor">Instrutor</label>
                        <select id="training_instructor" class="form-input">
                            <option>Carlos Mendes</option>
                            <option>Fernanda Rocha</option>
                            <option>Ricardo Alves</option>
                            <option>Juliana Prado</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label" for="training_scheduled">Data e hora</label>
                        <input id="training_scheduled" class="form-input" type="datetime-local" />
                    </div>
                    <div>
                        <label class="form-label" for="training_hours">Carga horária (h)</label>
                        <input id="training_hours" class="form-input" type="number" min="1" placeholder="8" />
                    </div>
                    <div>
                        <label class="form-label" for="training_capacity">Vagas</label>
                        <input id="training_capacity" class="form-input" type="number" min="1" placeholder="20" />
                    </div>
                </div>
                <div class="flex justify-end gap-2 border-t border-slate-100 bg-slate-50 px-6 py-4">
                    <button type="button" class="btn btn-secondary" onclick="toggleModal('newTrainingModal')">Cancelar</button>
                    <button type="submit" class="btn btn-primary"><i data-lucide="check"></i>Agendar</button>
                </div>
            </form>
        </x-modal>

        {{-- Lista de presença (protótipo visual) --}}
        <x-modal id="attendanceModal" title="Lista de presença" subtitle="NR-35 Trabalho em Altura · 02/10/2026" icon="clipboard-check" size="max-w-xl">
            <ul class="max-h-96 divide-y divide-slate-100 overflow-y-auto">
                @foreach ($attendees as $attendee)
                    <li>
                        <label class="flex cursor-pointer items-center gap-3 px-6 py-3 hover:bg-slate-50">
                            <x-avatar :name="$attendee['name']" class="size-9 text-xs" />
                            <div class="flex-1">
                                <p class="text-sm font-medium text-slate-900">{{ $attendee['name'] }}</p>
                                <p class="font-mono text-xs text-slate-500">{{ $attendee['registration'] }}</p>
                            </div>
                            <input type="checkbox" class="form-checkbox size-5" @checked($attendee['present'])>
                        </label>
                    </li>
                @endforeach
            </ul>
            <div class="flex items-center justify-between gap-2 border-t border-slate-100 bg-slate-50 px-6 py-4">
                <p class="text-xs text-slate-500">4 de 6 presentes</p>
                <div class="flex gap-2">
                    <button type="button" class="btn btn-secondary" onclick="toggleModal('attendanceModal')">Fechar</button>
                    <button type="button" class="btn btn-primary" onclick="toggleModal('attendanceModal')">
                        <i data-lucide="save"></i>Salvar presença
                    </button>
                </div>
            </div>
        </x-modal>
    </x-slot:modals>

    <x-slot:actions>
        <button type="button" onclick="toggleModal('newTrainingModal')" class="btn btn-primary">
            <i data-lucide="calendar-plus"></i><span class="hidden sm:inline">Agendar aula</span>
        </button>
    </x-slot:actions>

    <div class="flex flex-col gap-6">
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <x-stat-card label="Agendadas" value="4" icon="calendar-clock" tone="accent" />
            <x-stat-card label="Concluídas no ano" value="38" icon="check-circle-2" tone="success" />
            <x-stat-card label="Horas de treinamento" value="1.240" icon="clock" />
            <x-stat-card label="Taxa de presença" value="92%" icon="user-check" tone="warning" />
        </div>

        {{-- Filtros por status --}}
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="inline-flex rounded-lg border border-slate-200 bg-white p-1 shadow-card" id="training-tabs">
                @foreach (['Todas', 'Agendado', 'Concluído', 'Cancelado'] as $tab)
                    <button type="button" data-filter="{{ $tab }}" onclick="filterTrainings(this)"
                        class="rounded-md px-3 py-1.5 text-sm font-medium text-slate-600 transition hover:text-slate-900 data-[active=true]:bg-brand-700 data-[active=true]:text-white"
                        data-active="{{ $tab === 'Todas' ? 'true' : 'false' }}">
                        {{ $tab === 'Todas' ? 'Todas' : $tab.'s' }}
                    </button>
                @endforeach
            </div>
            <div class="relative sm:w-72">
                <i data-lucide="search" class="pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2 text-slate-400"></i>
                <input type="search" oninput="searchTrainings(this.value)" class="form-input pl-9" placeholder="Buscar aula ou instrutor...">
            </div>
        </div>

        {{-- Cartões das aulas --}}
        <div class="grid gap-5 md:grid-cols-2 2xl:grid-cols-3" id="training-list">
            @foreach ($trainings as $training)
                @php
                    $fill = round($training['enrolled'] * 100 / $training['capacity']);
                @endphp
                <article class="card flex flex-col transition hover:shadow-elevated" data-status="{{ $training['status'] }}"
                    data-search="{{ mb_strtolower($training['nr'].' '.$training['title'].' '.$training['instructor']) }}">
                    <div class="flex items-start justify-between gap-3 p-5">
                        <div class="flex items-start gap-3">
                            <div class="bg-gradient-primary flex size-12 shrink-0 flex-col items-center justify-center rounded-xl text-white">
                                <span class="text-[10px] leading-none opacity-80">NR</span>
                                <span class="text-base leading-tight font-bold">{{ substr($training['nr'], 3) }}</span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-slate-900">{{ $training['title'] }}</h3>
                                <p class="text-xs text-slate-500">{{ $training['nr'] }} · {{ $training['hours'] }}h</p>
                            </div>
                        </div>
                        <span class="badge {{ $statusBadges[$training['status']] }}">{{ $training['status'] }}</span>
                    </div>

                    <dl class="grid grid-cols-2 gap-3 px-5 text-sm">
                        <div class="flex items-center gap-2 text-slate-600">
                            <i data-lucide="calendar" class="size-4 text-slate-400"></i>{{ $training['date'] }}
                        </div>
                        <div class="flex items-center gap-2 text-slate-600">
                            <i data-lucide="clock" class="size-4 text-slate-400"></i>{{ $training['time'] }}
                        </div>
                        <div class="flex items-center gap-2 text-slate-600">
                            <i data-lucide="user-round" class="size-4 text-slate-400"></i><span class="truncate">{{ $training['instructor'] }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-slate-600">
                            <i data-lucide="map-pin" class="size-4 text-slate-400"></i><span class="truncate">{{ $training['location'] }}</span>
                        </div>
                    </dl>

                    <div class="p-5">
                        <div class="flex justify-between text-xs text-slate-500">
                            <span>Inscritos</span>
                            <span class="font-semibold text-slate-700">{{ $training['enrolled'] }}/{{ $training['capacity'] }}</span>
                        </div>
                        <div class="mt-1.5 h-1.5 overflow-hidden rounded-full bg-slate-100">
                            <div class="h-full rounded-full {{ $fill >= 100 ? 'bg-emerald-500' : 'bg-brand-500' }}" style="width: {{ $fill }}%"></div>
                        </div>
                    </div>

                    <div class="mt-auto flex gap-2 border-t border-slate-100 px-5 py-3">
                        <button type="button" onclick="toggleModal('attendanceModal')" class="btn btn-secondary btn-sm flex-1">
                            <i data-lucide="clipboard-check"></i>Presença
                        </button>
                        <button type="button" class="btn btn-ghost btn-sm" title="Editar">
                            <i data-lucide="pencil"></i>
                        </button>
                    </div>
                </article>
            @endforeach
        </div>

        <div id="training-empty" class="card hidden flex-col items-center py-16 text-center">
            <i data-lucide="calendar-x" class="size-10 text-slate-300"></i>
            <p class="mt-3 font-medium text-slate-700">Nenhuma aula encontrada</p>
        </div>
    </div>

    <script>
        let trainingStatusFilter = 'Todas';
        let trainingSearch = '';

        function applyTrainingFilters() {
            let visible = 0;

            document.querySelectorAll('#training-list > article').forEach((card) => {
                const matchesStatus = trainingStatusFilter === 'Todas' || card.dataset.status === trainingStatusFilter;
                const matchesSearch = card.dataset.search.includes(trainingSearch);
                const show = matchesStatus && matchesSearch;

                card.classList.toggle('hidden', !show);
                visible += show ? 1 : 0;
            });

            const empty = document.getElementById('training-empty');
            empty.classList.toggle('hidden', visible > 0);
            empty.classList.toggle('flex', visible === 0);
        }

        function filterTrainings(button) {
            trainingStatusFilter = button.dataset.filter;
            document.querySelectorAll('#training-tabs button').forEach((tab) => {
                tab.dataset.active = tab === button ? 'true' : 'false';
            });
            applyTrainingFilters();
        }

        function searchTrainings(value) {
            trainingSearch = value.trim().toLowerCase();
            applyTrainingFilters();
        }
    </script>
</x-app-layout>
