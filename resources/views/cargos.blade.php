<x-layout>
    <div class="grid-cols-4 grid gap-5 p-5 max-h-full overflow-y-scroll">
        @foreach ($cargos as $cargo)
            <div
                class="p-5 box-shadow-xl rounded-xl flex flex-col gap-5 w-full border-[rgb(0,0,0,0.25)] border justify-between">
                <div class="leading-none">
                    <h3 class="text-3xl font-bold">{{ $cargo->title }}</h3>
                    <p>Usuario Padrão</p>
                </div>
                <div class="leading-none text-[16px]">
                    <p>Criado em: {{ $cargo->created_at }}</p>
                    <p>Status: {{ $cargo->created_at }}</p>
                </div>
                <div class="w-full flex justify-between">
                    @if ($cargo->status === 'Ativo')
                        <form id={{ $cargo->id }} action="/teste" method="POST">
                            @csrf
                            <button class="p-3 bg-[#db3e22] text-white rounded">
                                Desativar
                            </button>
                        </form>
                    @else
                        <form id={{ $cargo->id }} action="" >
                            @csrf
                            <button class="p-3 bg-[#637EB0] text-white rounded">
                                Ativar
                            </button>
                        </form>
                    @endif

                    <form id={{ $cargo->id }} action="">
                        <button class="p-3 bg-[#637EB0] text-white rounded">
                            Editar
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</x-layout>
