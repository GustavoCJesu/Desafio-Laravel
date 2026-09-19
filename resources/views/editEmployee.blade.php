<x-layout>
    <main class="flex-1 flex">
        <x-sidebar-menu />
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach

        @endif
        <div class="min-h-full w-full flex align-center">
            <div class="bg-white h-fit m-auto  rounded-sm overflow-hidden shadow-xl border border-[rgb(0,0,0,0.25)]">
                <div class="rounded">
                    <div class="bg-gradient-primary px-4 py-2 text-white">
                        <h2 class="text-xl font-bold uppercase">
                            Cadastro do funcionário
                        </h2>
                    </div>
                    <form method="POST" action={{ route('employee.update', $employee->id) }}>
                        @csrf
                        @method('PUT')
                        <div class="p-10 flex flex-col gap-3">
                            <div class="flex flex-col">
                                <label>Nome Completo: </label>
                                <input name="name" class="border border-[rgb(0,0,0,0.25)] rounded p-1" type="text"
                                    value="{{ $employee->name }}" />
                            </div>
                            <div class="flex flex-col">
                                <label>CPF: </label>
                                <input name="cpf" class="cpf border border-[rgb(0,0,0,0.25)] rounded p-1"
                                    type="text" value="{{ $employee->cpf }}" />
                            </div>
                            <div class="flex flex-col">
                                <label>Matrícula: </label>
                                <input name="registration" readonly class="border border-[rgb(0,0,0,0.25)] rounded p-1"
                                    type="text" value="{{ $employee->registration }}" />
                            </div>
                            <div class="flex flex-col">
                                <label>Setor: </label>
                                <select name="sector_id" class="p-2 rounded border border-[rgb(0,0,0,0.25)]">
                                    @foreach ($sectors as $sector)
                                        <option {{ $employee->sector_id === $sector->id ? 'selected' : '' }}
                                            value="{{ $sector->id }}">
                                            {{ $sector->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex flex-col">
                                <label>Cargo: </label>
                                <select name="company_role_id" class="p-2 rounded border border-[rgb(0,0,0,0.25)]">
                                    @foreach ($roles as $role)
                                        <option value={{ $role->id }}
                                            {{ $employee->company_role_id === $role->id ? 'selected' : '' }}>
                                            {{ $role->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex gap-2">
                                <label>
                                    Status:
                                </label>
                                <p class="{{ $employee->status === 'Ativo' ? 'text-green-500' : 'text-red-500' }}">
                                    {{ $employee->status }}
                                </p>
                            </div>

                            <div class="flex justify-between w-full text-white">
                                <button class="bg-gradient-errors font-bold p-2 rounded hover:scale-110 transition">
                                    Excluir
                                </button>
                                <button type="submit"
                                    class="bg-gradient-primary font-bold p-2 rounded hover:scale-110 transition">
                                    Salvar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if ($users->contains('employee_id', $employee->id))
                <div class="bg-white h-fit m-auto rounded shadow-xl border border-[rgb(0,0,0,0.25)]">
                    <div class="rounded">
                        <div class="bg-gradient-primary px-4 py-2 text-white">
                            <h2 class="text-xl font-bold uppercase">
                                Dados do usuário
                            </h2>
                        </div>
                        <form action="{{ route('user.update', $employee->user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="p-10 flex flex-col gap-3">
                                <div class="flex flex-col">
                                    <label>Email: </label>
                                    <input name="email" class="border border-[rgb(0,0,0,0.25)] rounded p-1" type="text"
                                        value="{{ $employee->user->email }}" />
                                </div>
                                <div class="flex flex-col">
                                    <label>Função do usuário: </label>
                                    <select name="user_role_id" class="p-1 rounded-md border border-[rgb(0,0,0,0.25)]">

                                        @foreach ($user_roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ $employee->user->userRole->id === $role->id ? 'selected' : '' }}>
                                                {{ $role->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex flex-col border border-[rgb(0,0,0,0.25)] p-1 rounded-md">
                                    <h2 class="font-bold text-xl">
                                        Permissões:
                                    </h2>
                                    <div class="p-1 text-[12px] flex">
                                        <div class="flex flex-col w-full">
                                            <h2 class="text-[15px] font-bold">Ver</h2>
                                            @foreach ($grouped['Ver'] as $permission)
                                                <div class="flex items-center gap-1 px-2">
                                                    <input onclick="return false;"
                                                        {{ $employee->user->userRole->rolePermissions->contains('permission_id', $permission->id) ? 'checked' : '' }}
                                                        name="permission" type="checkbox"
                                                        value="{{ $permission->id }}" />
                                                    <label for="permission">
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="flex flex-col w-full">
                                            <h2 class="text-[15px] font-bold">Criar</h2>
                                            @foreach ($grouped['Criar'] as $permission)
                                                <div class="flex items-center gap-1 px-2">
                                                    <input onclick="return false;"
                                                        {{ $employee->user->userRole->rolePermissions->contains('permission_id', $permission->id) ? 'checked' : '' }}
                                                        name="permission" type="checkbox"
                                                        value="{{ $permission->id }}" />
                                                    <label for="permission">
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="p-1 text-[12px] flex">
                                        <div class="flex flex-col w-full">
                                            <h2 class="text-[15px] font-bold">
                                                Editar
                                            </h2>
                                            @foreach ($grouped['Editar'] as $permission)
                                                <div class="flex items-center gap-1 px-2">
                                                    <input onclick="return false;"
                                                        {{ $employee->user->userRole->rolePermissions->contains('permission_id', $permission->id) ? 'checked' : '' }}
                                                        name="permission" type="checkbox"
                                                        value="{{ $permission->id }}" />
                                                    <label for="permission">
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="flex flex-col w-full">
                                            <h2 class="text-[15px] font-bold">Apagar</h2>
                                            @foreach ($grouped['Apagar'] as $permission)
                                                <div class="flex items-center gap-1 px-2">
                                                    <input onclick="return false;"
                                                        {{ $employee->user->userRole->rolePermissions->contains('permission_id', $permission->id) ? 'checked' : '' }}
                                                        name="permission" type="checkbox"
                                                        value="{{ $permission->id }}" />
                                                    <label for="permission">
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="flex gap-2 justify-between">
                                    <div class="flex gap-1">
                                        <label>
                                            Status:
                                        </label>
                                        <p
                                            class="{{ $employee->status === 'Ativo' ? 'text-green-500' : 'text-red-500' }}">
                                            {{ $employee->status }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex justify-between w-full text-white">
                                    <button class="bg-gradient-errors font-bold p-2 rounded hover:scale-110 transition">
                                        Desativar
                                    </button>
                                    <button
                                        class="bg-gradient-primary font-bold p-2 rounded hover:scale-110 transition">
                                        Salvar
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            @else
                <x-create-user-modal :employee="$employee" :user_roles="$user_roles" />
                <div
                    class="bg-white h-fit m-auto rounded-sm overflow-hidden shadow-xl border border-[rgb(0,0,0,0.25)] text-center flex flex-col gap-3">
                    <div class="bg-gradient-primary text-white p-2">
                        <h2 class="font-medium uppercase">
                            Este funcionário não tem um usuário no sistema.
                        </h2>
                        <p class="font-light">
                            Deseja criar?
                        </p>
                    </div>
                    <div class="p-2">
                        <button onclick="toggleModal('userModal')"
                            class="cursor-pointer px-4 py-2 bg-gradient-primary text-white font-bold rounded hover:scale-110 transition">
                            Criar
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </main>
    <script>
        const cpfs = document.querySelectorAll('.cpf')

        cpfs.forEach(cpf => {
            cpf.addEventListener('input', function() {
                let value = this.value.replace(/\D/g, '');

                // Limita a 11 números
                value = value.substring(0, 11);

                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');

                this.value = value;
            })
        });
    </script>
</x-layout>
