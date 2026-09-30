<x-layouts.app title="Aulas" subtitle="Treinamentos e reciclagens das Normas Regulamentadoras" icon="graduation-cap">
    <x-slot:modals>
        <x-modals.training-create :instructors="$instructors" />
        <x-modals.training-attendance />
    </x-slot:modals>

    <x-slot:actions>
        <button type="button" onclick="toggleModal('newTrainingModal')" class="btn btn-primary">
            <i data-lucide="calendar-plus"></i><span class="hidden sm:inline">Agendar aula</span>
        </button>
    </x-slot:actions>

    <div class="flex flex-col gap-6">
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <x-ui.stat-card label="Agendadas" value="4" icon="calendar-clock" tone="accent" />
            <x-ui.stat-card label="Concluídas no ano" value="38" icon="check-circle-2" tone="success" />
            <x-ui.stat-card label="Horas de treinamento" value="1.240" icon="clock" />
            <x-ui.stat-card label="Taxa de presença" value="92%" icon="user-check" tone="warning" />
        </div>

        {{-- Filtros por status --}}
        {{-- <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
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
        </div> --}}

        <div class="grid gap-5 md:grid-cols-2 2xl:grid-cols-3" id="training-list">
            @forelse ($trainings as $training)
                <article class="card flex cursor-pointer flex-col transition hover:shadow-elevated"
                    data-status="Agendado" data-search="nr-35 trabalho em altura carlos mendes"
                    onclick="window.location='{{ route('training.edit', $training->id) }}'">
                    <div class="flex items-start justify-between gap-3 p-5">
                        <div class="flex items-start gap-3">
                            <div
                                class="bg-gradient-primary flex size-12 shrink-0 flex-col items-center justify-center rounded-xl text-white">
                                <span class="text-[10px] leading-none opacity-80">{{ $training->norm }}</span>
                                <span
                                    class="text-base leading-tight font-bold">{{ preg_replace('/[^0-9]/', '', $training->norm) }}</span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-slate-900">{{ $training->title }}</h3>
                                <p class="text-xs text-slate-500">{{ $training->norm }} ·
                                    {{ $training->scheduled->format('H:i') }}</p>
                            </div>
                        </div>
                        <span class="badge badge-info">Agendado</span>
                    </div>

                    <dl class="grid grid-cols-2 gap-3 px-5 text-sm">
                        <div class="flex items-center gap-2 text-slate-600">
                            <i data-lucide="calendar"
                                class="size-4 text-slate-400"></i>{{ $training->scheduled->format('d/m/Y') }}
                        </div>
                        <div class="flex items-center gap-2 text-slate-600">
                            <i data-lucide="clock"
                                class="size-4 text-slate-400"></i>{{ $training->scheduled->format('H:i') }}
                        </div>
                        <div class="flex items-center gap-2 text-slate-600">
                            <i data-lucide="user-round" class="size-4 text-slate-400"></i><span class="truncate">
                                {{ $training->instructor->name }} </span>
                        </div>
                        <div class="flex items-center gap-2 text-slate-600">
                            <i data-lucide="map-pin" class="size-4 text-slate-400"></i><span class="truncate">
                                {{ $training->location }} </span>
                        </div>
                    </dl>

                    <div class="p-5">
                        <div class="flex justify-between text-xs text-slate-500">
                            <span>Inscritos</span>
                            <span class="font-semibold text-slate-700">2/{{$training->capacity}}</span>
                        </div>
                        <div class="mt-1.5 h-1.5 overflow-hidden rounded-full bg-slate-100">
                            <div class="h-full rounded-full bg-brand-500" style="width: {{ (2 / $training->capacity) * 100 }}% "></div>
                        </div>
                    </div>

                    <div class="mt-auto flex gap-2 border-t border-slate-100 px-5 py-3">
                        <button type="button" onclick="event.stopPropagation(); toggleModal('attendanceModal')"
                            class="btn btn-secondary btn-sm flex-1">
                            <i data-lucide="clipboard-check"></i>Presença
                        </button>
                        <a href="{{ route('training.edit', $training->id) }}" class="btn btn-ghost btn-sm"
                            title="Editar">
                            <i data-lucide="pencil"></i>
                        </a>
                    </div>
                </article>
            @empty
                {{-- Lugar para se caso nenhuma aula estiver cadastrada --}}
                <div id="training-empty" class="card hidden flex-col items-center py-16 text-center">
                    <i data-lucide="calendar-x" class="size-10 text-slate-300"></i>
                    <p class="mt-3 font-medium text-slate-700">Nenhuma aula encontrada</p>
                </div>
            @endforelse
        </div>
    </div>

    <script>
        let trainingStatusFilter = 'Todas';
        let trainingSearch = '';

        function applyTrainingFilters() {
            let visible = 0;

            document.querySelectorAll('#training-list > article').forEach((card) => {
                const matchesStatus = trainingStatusFilter === 'Todas' || card.dataset.status ===
                    trainingStatusFilter;
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
</x-layouts.app>
