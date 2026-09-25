<x-layout>
    <x-link-employee-modal :training="$training" :employees="$employees" :classes="$classes" />
    <x-link-epi-modal :training="$training" :epis="$epis" />

    <main class="flex flex-1">
        <x-sidebar-menu />
        <div class="flex flex-col max-h-screen min-h-screen flex-1 p-6 gap-4">
            <div class="bg-gradient-primary uppercase font-bold text-2xl text-white px-6 py-4 rounded-md flex justify-between items-center">
                <span>{{ $training->title }}</span>
                <a href="{{ route('training.index') }}" class="text-sm font-normal normal-case hover:underline">
                    Voltar para Aulas
                </a>
            </div>

            <div class="grid grid-cols-2 gap-4 flex-1 min-h-0">
                <div class="flex flex-col gap-2 min-h-0">
                    <p class="font-bold uppercase text-lg">Funcionários vinculados</p>

                    <div class="flex-1 min-h-0 overflow-y-auto rounded-lg border border-gray-200 shadow-md p-2 flex flex-col gap-4">
                        @forelse ($classes as $class)
                            <div>
                                <p class="font-bold text-sm bg-gray-100 px-2 py-1 rounded">
                                    Aula de {{ $class->class_dt->format('d/m/Y') }}
                                </p>
                                <table class="w-full border border-gray-300 text-left rounded overflow-auto text-[12px]">
                                    <thead class="bg-gradient-primary text-[#DCE7FA]">
                                        <tr>
                                            <th>Funcionário</th>
                                            <th>Presença</th>
                                            <th> {{-- Remover --}} </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white text-black">
                                        @forelse ($attendancesByClass->get($class->id, collect()) as $attendance)
                                            <tr class="border-b border-gray-300 hover:bg-gray-200 transition duration-100 ease-in-out">
                                                <td>{{ $attendance->employee->name ?? 'N/A' }}</td>
                                                <td
                                                    class="{{ $attendance->employee_attendence === 'Falta' ? 'text-red-600' : 'text-green-600' }}">
                                                    {{ $attendance->employee_attendence }}
                                                </td>
                                                <td>
                                                    <form action="{{ route('attendance.destroy', [$training->id, $attendance->id]) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" title="Remover"
                                                            class="text-red-600 hover:scale-120 transition cursor-pointer">
                                                            <i data-lucide="trash-2"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center p-2">Nenhum funcionário vinculado a esta data ainda.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        @empty
                            <p class="text-center p-4">
                                Nenhuma data de aula cadastrada.
                                <a href="{{ route('training.viewUpdate', $training->id) }}" class="underline">Cadastre as datas</a>
                                antes de vincular funcionários.
                            </p>
                        @endforelse
                    </div>

                    <button type="button" onclick="toggleModal('linkEmployeeModal')" @disabled($classes->isEmpty())
                        class="flex items-center justify-center gap-2 bg-gradient-primary p-3 text-white rounded hover:scale-105 transition cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed">
                        <i data-lucide="plus"></i>Vincular Funcionário
                    </button>
                </div>

                <div class="flex flex-col gap-2 min-h-0">
                    <p class="font-bold uppercase text-lg">EPIs abordados</p>

                    <div class="flex-1 min-h-0 overflow-y-auto rounded-lg border border-gray-200 shadow-md">
                        <table class="w-full border border-gray-300 text-left rounded overflow-auto text-[12px]">
                            <thead class="bg-gradient-primary text-[#DCE7FA] sticky top-0 z-10">
                                <tr class="bg-gradient-primary text-[#DCE7FA]">
                                    <th>Nome</th>
                                    <th>CA</th>
                                    <th>Categoria</th>
                                    <th> {{-- Remover --}} </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white text-black">
                                @forelse ($linkedEpis as $epi)
                                    <tr class="border-b border-gray-300 hover:bg-gray-200 transition duration-100 ease-in-out">
                                        <td>{{ $epi->name }}</td>
                                        <td>{{ $epi->ca }}</td>
                                        <td>{{ $epi->category->name ?? 'N/A' }}</td>
                                        <td>
                                            <form action="{{ route('attendance.epis.destroy', [$training->id, $epi->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="Remover"
                                                    class="text-red-600 hover:scale-120 transition cursor-pointer">
                                                    <i data-lucide="trash-2"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center p-4">Nenhum EPI vinculado a esta aula ainda.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <button type="button" onclick="toggleModal('linkEpiModal')"
                        class="flex items-center justify-center gap-2 bg-gradient-primary p-3 text-white rounded hover:scale-105 transition cursor-pointer">
                        <i data-lucide="plus"></i>Vincular EPI
                    </button>
                </div>
            </div>
        </div>
    </main>
</x-layout>
