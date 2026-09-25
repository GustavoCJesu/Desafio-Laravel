<div id="positionModal" class="z-20 absolute hidden top-0 left-0 h-screen w-screen bg-[rgb(0,0,0,0.8)] justify-center align-center">

        <div class="bg-white h-fit w-140 m-auto rounded-md overflow-hidden flex flex-col justify-center">
            <div class="bg-gradient-primary p-4 text-white">
                <h2 class="text-xl font-bold uppercase">
                    Novo usuário
                </h2>
            </div>
            <form action="{{ route('position.create') }}" method="POST" id="positionForm">
                @csrf
                <div class="p-5 flex flex-col gap-3 mt-3">
                    <div class="flex flex-col">
                        <label class="font-bold" for="email">Titulo: </label>
                        <input name="title"
                            class="border border-[rgb(0,0,0,0.25)] rounded p-2" type="text" />
                    </div>
                    <p class="font-bold text-md">
                        Permissões
                    </p>
                    <div class="grid grid-cols-2">
                        <div>
                            <p class="text-md font-bold uppercase ">Ver</p>
                            <div class="p-2">
                                @foreach ($grouped['Ver'] as $permission)
                                    <div class="flex items-center gap-1">
                                        <input name="permission_{{ $permission->id }}" value="{{ $permission->id }}" type="checkbox" /><label
                                            for="permission_{{ $permission->id }}">{{ $permission->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div>
                            <p class="text-md font-bold uppercase ">Criar</p>
                            <div class="p-2">
                                @foreach ($grouped['Criar'] as $permission)
                                    <div class="flex items-center gap-1">
                                        <input name="permission_{{ $permission->id }}" value="{{ $permission->id }}" type="checkbox" /><label
                                            for="permission_{{ $permission->id }}">{{ $permission->name }}</label>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                        <div>
                            <p class="text-md font-bold uppercase ">Editar</p>
                            <div class="p-2">
                                @foreach ($grouped['Editar'] as $permission)
                                    <div class="flex items-center gap-1">
                                        <input name="permission_{{ $permission->id }}" value="{{ $permission->id }}" type="checkbox" /><label
                                            for="permission_{{ $permission->id }}">{{ $permission->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div>
                            <p class="text-md font-bold uppercase ">Apagar</p>
                            <div class="p-2">
                                @foreach ($grouped['Apagar'] as $permission)
                                    <div class="flex gap-1">
                                        <input name="permission_{{ $permission->id }}" value="{{ $permission->id }}" type="checkbox" /><label
                                            for="permission_{{ $permission->id }}">{{ $permission->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between p-4">
                        <button form="positionForm"
                            class="bg-gradient-primary text-white px-4 py-2 rounded hover:scale-110 transition">
                            Criar
                        </button>
                        <span onclick="toggleModal('positionModal')"
                            class="bg-gradient-errors text-white px-4 py-2 rounded hover:scale-110 transition">
                            Cancelar
                        </span>
                    </div>
                </div>
            </form>
        </div>
    </div>