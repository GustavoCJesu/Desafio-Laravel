@props(['roles', 'sectors', 'employee' => null, 'user_roles'])

<div id="userModal"
    class="absolute hidden top-0 left-0 h-screen w-screen bg-[rgb(0,0,0,0.8)] justify-center align-center">

    <div class="bg-white h-fit w-100 m-auto rounded-md overflow-hidden">
        <div class="bg-gradient-primary p-4 text-white">
            <h2 class="text-xl font-bold uppercase">
                Novo usuário
            </h2>
        </div>
        <form method="POST" action="{{ route('user.create') }}" id="createUserForm">
            @csrf
            <div class="p-5 flex flex-col gap-3 mt-3">
                <input name="employee_id" class="hidden" type="number" value="{{ $employee->id }}">
                <div class="flex flex-col">
                    <label class="font-bold" for="email">Funcionário: </label>
                    <input value="{{ $employee->name }}" name="employee_name" readonly
                        class="border border-[rgb(0,0,0,0.25)] rounded p-2" type="text" />
                </div>
                <div class="flex flex-col">
                    <label class="font-bold" for="email">Email: </label>
                    <input required name="email" class="border border-[rgb(0,0,0,0.25)] rounded p-2" type="email" />
                </div>
                <div class="flex flex-col">
                    <label class="font-bold" for="email">Senha: </label>
                    <input required name="password" class="border border-[rgb(0,0,0,0.25)] rounded p-2" type="password" />
                </div>
                <div class="flex flex-col">
                    <label class="font-bold" for="email">Confirmar Senha: </label>
                    <input required name="password_confirmation" class="border border-[rgb(0,0,0,0.25)] rounded p-2"
                        type="password" />
                </div>
                <div class="flex flex-col">
                    <label class="font-bold" for="email">Função: </label>
                    <select class="border border-[rgb(0,0,0,0.25)] rounded p-2" name="user_role_id" id="">
                        @foreach ($user_roles as $role)
                            <option value={{ $role->id }}>
                                {{ $role->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-between p-4">
                    <button form="createUserForm" class="bg-gradient-primary text-white px-4 py-2 rounded hover:scale-110 transition">
                        Criar
                    </button>
                    <button onclick="toggleModal('userModal')"
                        class="bg-gradient-errors text-white px-4 py-2 rounded hover:scale-110 transition">
                        Cancelar
                    </button>
                </div>
            </div>
        </form>
    </div>

</div>
