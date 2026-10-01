@props(['attendees' => []])

@php
    $presentCount = collect($attendees)->where('present', true)->count();
@endphp

{{-- Lista de presença (protótipo visual) --}}
<x-ui.modal id="attendanceModal" title="Lista de presença" subtitle="NR-35 Trabalho em Altura · 02/10/2026"
    icon="clipboard-check" size="max-w-xl">
    <ul class="max-h-96 divide-y divide-slate-100 overflow-y-auto" id="list">
        @foreach ($attendees as $attendee)
            {{-- <li>
                <label class="flex cursor-pointer items-center gap-3 px-6 py-3 hover:bg-slate-50">
                    <x-ui.avatar :name="$attendee['name']" class="size-9 text-xs" />
                    <div class="flex-1">
                        <p class="text-sm font-medium text-slate-900">{{ $attendee['name'] }}</p>
                        <p class="font-mono text-xs text-slate-500">{{ $attendee['registration'] }}</p>
                    </div>
                    <input type="checkbox" class="form-checkbox size-5" @checked($attendee['present'])>
                </label>
            </li> --}}
        @endforeach
    </ul>
    <div class="flex items-center justify-between gap-2 border-t border-slate-100 bg-slate-50 px-6 py-4">
        <p class="text-xs text-slate-500">{{ $presentCount }} de {{ count($attendees) }} presentes</p>
        <div class="flex gap-2">
            <button type="button" class="btn btn-secondary" onclick="toggleModal('attendanceModal')">Fechar</button>
            <button type="button" class="btn btn-primary" onclick="toggleModal('attendanceModal')">
                <i data-lucide="save"></i>Salvar presença
            </button>
        </div>
    </div>
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
