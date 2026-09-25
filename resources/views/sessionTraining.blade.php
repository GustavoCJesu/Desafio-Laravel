<x-layout>
    <x-create-training-modal :instructors="$instructors" />

    <main class="flex flex-1">
        <x-sidebar-menu />
        <div class="flex flex-col max-h-screen min-h-screen flex-1 p-6 gap-4 justify-between">
            <div class="flex flex-col gap-4 flex-1 min-h-0">
                <div class="bg-gradient-primary uppercase font-bold text-2xl text-white px-6 py-4 rounded-md">
                    Aulas
                </div>

                <div class="flex-1 min-h-0 overflow-y-auto rounded-lg border border-gray-200 shadow-md">
                    <table class="w-full border border-gray-300 text-left rounded overflow-auto text-[12px]">
                        <thead class="bg-gradient-primary text-[#DCE7FA] sticky top-0 z-10">
                            <tr class="bg-gradient-primary text-[#DCE7FA]">
                                <th>Título</th>
                                <th>Instrutor</th>
                                <th>Agendado para</th>
                                <th>Qtd. Aulas</th>
                                <th>Carga mín. (h)</th>
                                <th>Validade</th>
                                <th>Status</th>
                                <th> {{-- Editar --}} </th>
                                <th> {{-- Ver --}} </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white text-black">
                            @foreach ($trainings as $training)
                                <tr class="border-b border-gray-300 hover:bg-gray-200 transition duration-100 ease-in-out">
                                    <td>{{ $training->title }}</td>
                                    <td>{{ $training->instructor->name ?? 'N/A' }}</td>
                                    <td>{{ $training->scheduled->format('d/m/Y H:i') }}</td>
                                    <td>{{ $training->class_amount }}</td>
                                    <td>{{ $training->class_min }}</td>
                                    <td>{{ $training->validity_dt->format('d/m/Y') }}</td>
                                    <td
                                        class="{{ $training->status === 'Cancelado' ? 'text-red-600' : ($training->status === 'Concluído' ? 'text-green-600' : 'text-yellow-600') }}">
                                        {{ $training->status }}
                                    </td>
                                    <td>
                                        <a href="{{ route('training.viewUpdate', $training->id) }}">
                                            <i class="text-gray-700 hover:scale-120 cursor-pointer transition"
                                                data-lucide="pencil"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('attendance.index', $training->id) }}">
                                            <i class="text-gray-700 hover:scale-120 cursor-pointer transition"
                                                data-lucide="eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex">
                <button type="button" onclick="toggleModal('trainingModal')"
                    class="flex items-center gap-2 bg-gradient-primary p-4 text-white rounded hover:scale-105 transition cursor-pointer">
                    <i data-lucide="plus"></i>Agendar Aula
                </button>
            </div>
        </div>
    </main>
</x-layout>
