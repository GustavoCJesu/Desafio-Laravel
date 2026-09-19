@props(['roles', 'sectors', 'employee' => null])

<div id="modal" class="z-50 absolute hidden top-0 left-0 h-screen w-screen bg-[rgb(0,0,0,0.8)] justify-center align-center">
    <form class="m-auto" method="POST" action={{ route('employees.create') }}>
        @csrf
        <div class="m-auto bg-white p-10 rounded flex flex-col gap-2">
            <h1 class="text-xl font-bold uppercase">
                Criar novo funcionário
            </h1>
            <div class="flex flex-col">
                <label class="font-bold" for="name">Nome Completo: </label>
                <input name="name" required placeholder="João da Silva"
                    class="border rounded border-[rgb(0,0,0,0.5)] shadow-md p-1" type="text" />
            </div>
            <div class="flex flex-col">
                <label class="font-bold" for="cpf">CPF: </label>
                <input name="cpf" required placeholder="000.000.000-00"
                    class="cpf border rounded border-[rgb(0,0,0,0.5)] shadow-md p-1" type="text" />
            </div>
            <div class="flex flex-col">
                <label class="font-bold" for="company_role_id">Cargo: </label>
                <select name="company_role_id"
                    class="appearance-none border border-[rgb(0,0,0,0.5)] p-1 rounded bg-white focus:outline-none focus:shadow-outline">
                    @foreach ($roles as $role)
                        <option value={{ $role->id }}>
                            {{ $role->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col">
                <label class="font-bold" for="sector_id">Setor: </label>
                <select required
                    class="appearance-none border border-[rgb(0,0,0,0.5)] p-1 rounded bg-white focus:outline-none focus:shadow-outline"
                    name="sector_id">
                    @foreach ($sectors as $sector)
                        <option value={{ $sector->id }}>
                            {{ $sector->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col">
                <label class="font-bold" for="cpf">Data de contratação: </label>
                <input name="hire_date"
                    class="appearance-none border border-[rgb(0,0,0,0.5)] p-1 rounded bg-white focus:outline-none focus:shadow-outline"
                    type="date" />
            </div>
            <div class="flex justify-between mt-4">
                <button type="submit"
                    class="bg-gradient-primary text-white px-4 py-2 rounded hover:scale-110 transition">
                    Criar
                </button>
                <button class="bg-gradient-errors text-white px-4 py-2 rounded hover:scale-110 transition"
                    onclick="toggleModal('modal')">
                    Cancelar
                </button>
            </div>
        </div>
    </form>
</div>
