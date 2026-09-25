<x-layout>
    <x-create-position-modal :grouped='$grouped' />

    @foreach ($positions as $position)
        <x-edit-position-modal :position="$position" :grouped="$grouped" />
    @endforeach

    {{-- <div class="absolute top-0 left-0 w-screen h-screen bg-[rgb(0,0,0,0.6)] flex justify-center items-center">
        <div class="bg-white p-2">
            <div>
                Editor de Cargo
            </div>
            <div>

            </div>
        </div>
    </div> --}}

    <main class="flex flex-1">
        <x-sidebar-menu />
        <div class="flex-1 p-4 flex flex-col justify-between">
            <div>
                <div class="bg-gradient-primary uppercase font-bold text-2xl text-white px-6 py-4 rounded-md">
                    Cargos do sistema
                </div>
                    <div class="grid grid-cols-4 p-4 gap-4">
                        @foreach ($positions as $position)
                            <div
                                class="w-full h-fit transition rounded overflow-hidden cursor-pointer border-[rgb(0,0,0,0.25)] border shadow-md">
                                <div>
                                    <p class="uppercase text-xl bg-gradient-primary px-2 py-1 text-white font-bold">
                                        {{ $position->title }}
                                    </p>
                                    <div class="p-3">
                                        <p>
                                            Criado em: {{ $position->created_at->format('d-m-Y') }}
                                        </p>
                                        <p>
                                            Status: {{ $position->status }}
                                        </p>
                                        <div class="flex justify-between mt-5">
                                            <button type="button" onclick="toggleModal('editPositionModal-{{ $position->id }}')"
                                                class="bg-gradient-primary text-white p-1 rounded hover:scale-105 cursor-pointer transition">
                                                Editar
                                            </button>
                                            <button
                                                class="bg-gradient-errors p-1 rounded text-white hover:scale-105 cursor-pointer transition">
                                                Excluir
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
            </div>

            <div class="flex ">
                <span onclick="toggleModal('positionModal')"
                    class="flex bg-gradient-primary p-4 text-white rounded hover:scale-105 transition cursor-pointer">
                    <i data-lucide="Plus"></i>Criar Novo Cargo
                </span>
            </div>
        </div>
    </main>
</x-layout>
