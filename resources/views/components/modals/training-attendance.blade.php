@props(['attendees' => [], 'id', 'classes' => []])
@php
    $presentCount = collect($attendees)->where('present', true)->count();
@endphp

{{-- Lista de presença (protótipo visual) --}}
<x-ui.modal id="attendanceModal{{ $id }}" title="Lista de presença"
    subtitle="NR-35 Trabalho em Altura · 02/10/2026" icon="clipboard-check" size="max-w-xl">
    <form action="{{ route('training.attendance', $sessionTraining = $id) }}" method="POST">
        @csrf
        <div class="border-b border-slate-100 px-6 py-4">
            <label for="attendanceClass{{ $id }}" class="form-label">Aula</label>
            @if (count($classes) === 0)
                <p class="text-blue-700 hover:scale-102 transition"><a href="{{ route('training.edit', $id) }}">Nenhuma aula cadastrada, crie uma agora.</a></p>
            @else
                <select name="class_id" id="attendanceClass{{ $id }}" class="form-input">
                    @foreach ($classes as $class)
                        <option  value="{{ $class->id }}">{{ $class->class_dt->format('d/m/Y H:i') }}</option>
                    @endforeach
                </select>
            @endif
        </div>
        <ul class="max-h-96 divide-y divide-slate-100 overflow-y-auto" id="list">
            @foreach ($attendees as $attendee)
                <li>
                    <label class="flex cursor-pointer items-center gap-3 px-6 py-3 hover:bg-slate-50">
                        <x-ui.avatar :name="$attendee['name']" class="size-9 text-xs" />
                        <div class="flex-1">
                            <p class="text-sm font-medium text-slate-900">{{ $attendee['name'] }}</p>
                            <p class="font-mono text-xs text-slate-500">{{ $attendee['registration'] }}</p>
                        </div>
                        <input value="{{ $attendee->id }}" name="employees[]" type="checkbox" class="form-checkbox size-5" @checked($attendee['present'])>
                    </label>
                </li>
            @endforeach
        </ul>
        <div class="flex items-center justify-between gap-2 border-t border-slate-100 bg-slate-50 px-6 py-4">
            <p class="text-xs text-slate-500">{{ $presentCount }} de {{ count($attendees) }} presentes</p>
            <div class="flex gap-2">
                <button type="button" class="btn btn-secondary"
                    onclick="toggleModal('attendanceModal{{ $id }}')">Fechar</button>
                <button type="submit" class="btn btn-primary" onclick="toggleModal('attendanceModal{{ $id }}')">
                    <i data-lucide="save"></i>Salvar presença
                </button>
            </div>
        </div>
    </form>
</x-ui.modal>

<script>
    import axios from 'axios'

    async function getSession(id) {

        try {

            const list = document.getElementById('list')
            const response = await axios.get(`/aula/${id}/show`)

            const attendees = response.data.training.employees

            console.log(attendees)

        } catch (e) {

        }
    }
</script>
