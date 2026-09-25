<x-layout>
    <main class="flex-1 flex">
        <x-sidebar-menu />
        <div class="min-h-full w-full flex align-center gap-4 justify-center">
            <div class="bg-white h-fit m-auto rounded-sm overflow-hidden shadow-xl border border-[rgb(0,0,0,0.25)]">
                <div class="rounded">
                    <div class="bg-gradient-primary px-4 py-2 text-white">
                        <h2 class="text-xl font-bold uppercase">
                            Editar aula
                        </h2>
                    </div>
                    <form method="POST" action="{{ route('training.update', $training->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="p-10 flex flex-col gap-3">
                            <div class="flex flex-col">
                                <label>Título: </label>
                                <input name="title" class="border border-[rgb(0,0,0,0.25)] rounded p-1" type="text"
                                    value="{{ $training->title }}" />
                            </div>
                            <div class="flex flex-col">
                                <label>Descrição: </label>
                                <textarea name="description" class="border border-[rgb(0,0,0,0.25)] rounded p-1">{{ $training->description }}</textarea>
                            </div>
                            <div class="flex flex-col">
                                <label>Instrutor: </label>
                                <select name="instructor_id" class="p-2 rounded border border-[rgb(0,0,0,0.25)]">
                                    @foreach ($instructors as $instructor)
                                        <option value="{{ $instructor->id }}"
                                            {{ $training->instructor_id === $instructor->id ? 'selected' : '' }}>
                                            {{ $instructor->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex gap-2">
                                <div class="flex flex-col w-full">
                                    <label>Data e hora: </label>
                                    <input name="scheduled" class="border border-[rgb(0,0,0,0.25)] rounded p-1"
                                        type="datetime-local"
                                        value="{{ $training->scheduled->format('Y-m-d\TH:i') }}" />
                                </div>
                                <div class="flex flex-col w-full">
                                    <label>Validade: </label>
                                    <input name="validity_dt" class="border border-[rgb(0,0,0,0.25)] rounded p-1"
                                        type="date" value="{{ $training->validity_dt->format('Y-m-d') }}" />
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <div class="flex flex-col w-full">
                                    <label>Qtd. de aulas: </label>
                                    <input name="class_amount" min="1"
                                        class="border border-[rgb(0,0,0,0.25)] rounded p-1" type="number"
                                        value="{{ $training->class_amount }}" />
                                </div>
                                <div class="flex flex-col w-full">
                                    <label>Carga mín. (h): </label>
                                    <input name="class_min" min="1"
                                        class="border border-[rgb(0,0,0,0.25)] rounded p-1" type="number"
                                        value="{{ $training->class_min }}" />
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <label>Status: </label>
                                <select name="status" class="p-2 rounded border border-[rgb(0,0,0,0.25)]">
                                    @foreach (['Agendado', 'Concluído', 'Cancelado'] as $status)
                                        <option value="{{ $status }}"
                                            {{ $training->status === $status ? 'selected' : '' }}>
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex justify-between w-full text-white mt-4">
                                <a href="{{ route('training.index') }}"
                                    class="bg-gradient-errors font-bold p-2 rounded hover:scale-110 transition">
                                    Voltar
                                </a>
                                <button type="submit"
                                    class="bg-gradient-primary font-bold p-2 rounded hover:scale-110 transition">
                                    Salvar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white h-fit m-auto rounded-sm overflow-hidden shadow-xl border border-[rgb(0,0,0,0.25)]">
                <div class="rounded">
                    <div class="bg-gradient-primary px-4 py-2 text-white">
                        <h2 class="text-xl font-bold uppercase">
                            Datas das aulas
                        </h2>
                    </div>
                    <div class="p-10 flex flex-col gap-3 w-80">
                        <table class="w-full border border-gray-300 text-left rounded text-[12px]">
                            <thead class="bg-gradient-primary text-[#DCE7FA]">
                                <tr>
                                    <th class="p-1">Data</th>
                                    <th> {{-- Remover --}} </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white text-black">
                                @forelse ($classes as $class)
                                    <tr class="border-b border-gray-300">
                                        <td class="p-1">{{ $class->class_dt->format('d/m/Y') }}</td>
                                        <td>
                                            <form
                                                action="{{ route('training.classes.destroy', [$training->id, $class->id]) }}"
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
                                        <td colspan="2" class="text-center p-4">Nenhuma data cadastrada ainda.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <form action="{{ route('training.classes.store', $training->id) }}" method="POST"
                            class="flex gap-2">
                            @csrf
                            <input name="class_dt" required type="date"
                                class="border border-[rgb(0,0,0,0.25)] rounded p-1 flex-1" />
                            <button type="submit"
                                class="bg-gradient-primary text-white px-3 rounded hover:scale-110 transition">
                                <i data-lucide="plus"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>
