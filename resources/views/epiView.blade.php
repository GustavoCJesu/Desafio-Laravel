<x-layout>
    <x-edit-epi-modal :categories="$categories" />

    <main class="flex flex-1">
        <x-sidebar-menu />
        <div class="flex flex-col max-h-screen min-h-screen flex-1 p-6 gap-4 justify-between">
            <div class="flex flex-col gap-4 flex-1 min-h-0">
                <div class="bg-gradient-primary uppercase font-bold text-2xl text-white px-6 py-4 rounded-md">
                    EPIs
                </div>

                <div class="flex-1 min-h-0 overflow-y-auto rounded-lg border border-gray-200 shadow-md">
                    <table class="w-full border border-gray-300 text-left rounded overflow-auto text-[12px]">
                        <thead class="bg-gradient-primary text-[#DCE7FA] sticky top-0 z-10">
                            <tr class="bg-gradient-primary text-[#DCE7FA]">
                                <th>CA</th>
                                <th>Nome</th>
                                <th>Categoria</th>
                                <th>Status</th>
                                <th> {{-- Editar --}} </th>
                                <th> {{-- Ver --}} </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white text-black ">
                            @foreach ($epis as $epi)
                                <tr class="border-b border-gray-300 hover:bg-gray-200 transition duration-100 ease-in-out">
                                    <td>{{ $epi->ca }}</td>
                                    <td>{{ $epi->name }}</td>
                                    <td>{{ $epi->category->name ?? 'N/A' }}</td>
                                    <td
                                        class="{{ $epi->status === 'Ativo' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $epi->status }}
                                    </td>
                                    <td>
                                        <i onclick="editEpi({{ $epi->id }})"
                                            class="text-gray-700 hover:scale-120 cursor-pointer transition"
                                            data-lucide="pencil"></i>
                                    </td>
                                    <td>
                                        <i class="text-gray-700 hover:scale-120 cursor-pointer transition"
                                            data-lucide="eye"></i>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex">
                <button type="button"
                    class="flex items-center gap-2 bg-gradient-primary p-4 text-white rounded hover:scale-105 transition cursor-pointer">
                    <i data-lucide="plus"></i>Adicionar EPI
                </button>
            </div>
        </div>
    </main>

    <script>
        function editEpi(id) {
            const showUrl = "{{ route('epi.show', ':id') }}".replace(':id', id);
            const updateUrl = "{{ route('epi.update', ':id') }}".replace(':id', id);

            fetch(showUrl)
                .then((response) => response.json())
                .then((epi) => {
                    document.getElementById('edit-epi-name').value = epi.name;
                    document.getElementById('edit-epi-ca').value = epi.ca;
                    document.getElementById('edit-epi-category').value = epi.category_id;
                    document.getElementById('edit-epi-status').value = epi.status;
                    document.getElementById('editEpiForm').action = updateUrl;

                    toggleModal('editEpiModal');
                });
        }
    </script>
</x-layout>
