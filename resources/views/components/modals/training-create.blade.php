@props(['norms' => ['NR-06', 'NR-10', 'NR-11', 'NR-12', 'NR-23', 'NR-33', 'NR-35'], 'instructors'])

<x-ui.modal id="newTrainingModal" title="Agendar aula" subtitle="Preencha os dados do treinamento." icon="calendar-plus" size="max-w-2xl">
    <form method="POST" action="{{ route('training.create') }}">
        @csrf
        <div class="grid gap-4 px-6 py-5 sm:grid-cols-2">
            <div>
                <label class="form-label" for="training_norm">Norma</label>
                <select id="training_norm" name="norm" required class="form-input">
                    @foreach ($norms as $norm)
                        <option value="{{ $norm }}">{{ $norm }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label" for="training_title">Título</label>
                <input id="training_title" name="title" required class="form-input" placeholder="Trabalho em Altura" type="text" />
            </div>
            <div class="sm:col-span-2">
                <label class="form-label" for="training_description">Descrição</label>
                <textarea id="training_description" name="description" required rows="3" class="form-input"
                    placeholder="Conteúdo programático da aula..."></textarea>
            </div>
            <div>
                <label class="form-label" for="training_instructor">Instrutor</label>
                <select id="training_instructor" name="instructor_id" required class="form-input">
                    @foreach ($instructors as $instructor)
                        <option value="{{ $instructor->id }}">{{ $instructor->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label" for="training_status">Status</label>
                <select id="training_status" name="status" class="form-input">
                    <option>Agendado</option>
                    <option>Concluído</option>
                    <option>Cancelado</option>
                </select>
            </div>
            <div>
                <label class="form-label" for="training_scheduled">Data e hora</label>
                <input id="training_scheduled" name="scheduled" required class="form-input" type="datetime-local" />
            </div>
            <div>
                <label class="form-label" for="training_validity">Validade do certificado</label>
                <input id="training_validity" name="validity_dt" required class="form-input" type="date" />
            </div>
            <div>
                <label class="form-label" for="training_hours">Carga horária (h)</label>
                <input id="training_hours" name="class_min" required class="form-input" type="number" min="1" placeholder="8" />
            </div>
            <div>
                <label class="form-label" for="training_amount">Qtd. de aulas</label>
                <input id="training_amount" name="class_amount" required class="form-input" type="number" min="1" placeholder="1" />
            </div>
            <div>
                <label class="form-label" for="training_capacity">Vagas</label>
                <input id="training_capacity" name="capacity" required class="form-input" type="number" min="1" placeholder="20" />
            </div>
            <div>
                <label class="form-label" for="training_location">Local</label>
                <input id="training_location" name="location" class="form-input" placeholder="Sala de treinamento 1" type="text" />
            </div>
        </div>
        <div class="flex justify-end gap-2 border-t border-slate-100 bg-slate-50 px-6 py-4">
            <button type="button" class="btn btn-secondary" onclick="toggleModal('newTrainingModal')">Cancelar</button>
            <button type="submit" class="btn btn-primary"><i data-lucide="check"></i>Agendar</button>
        </div>
    </form>
</x-ui.modal>
