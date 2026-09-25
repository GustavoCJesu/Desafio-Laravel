<x-layout>

    {{-- Modal --}}
    <x-create-employee-modal :roles="$roles" :sectors="$sectors" />
    <main class="flex-1 flex">
        {{-- Menu Lateral --}}
        <x-sidebar-menu />
        <div class="flex flex-col max-h-screen min-h-screen flex-1 p-6 gap-2 justify-between">
            <div>
                <form id="filter" method="GET" action="{{ route('employees.index') }}">
                    @csrf
                    <div class="w-full flex align-center justify-between h-fit bg-gradient-primary p-2 rounded">
                        <div class="flex align-center gap-4">
                            <input class="w-87 bg-white p-2 rounded" placeholder="João Silva" type="search" name="search"
                                id="" value={{ $search ?? '' }}>
                            <a href="{{ route('employees.index') }}"
                                class="bg-gray-500 hover:bg-gray-600 text-white p-2 rounded flex justify-center items-center">
                                <i class="w-5  h-auto text-white hover:scale-120 transition"
                                    data-lucide="rotate-ccw"></i>
                            </a>
                        </div>
                        <div class="flex gap-5 align-center">
                            <div class="flex align-center bg-white rounded p-2 gap-2 m-auto">
                                <p>Status: </p>
                                <div>
                                    <select onchange="sendForm()"
                                        class="appearance-none bg-whitetext-gray-700 focus:outline-none focus:shadow-outline"
                                        id="status" name="status">
                                        <option value="">Todos</option>
                                        <option value="Ativo" {{ request('status') == 'Ativo' ? 'selected' : '' }}>
                                            Ativo</option>
                                        <option value="Inativo" {{ request('status') == 'Inativo' ? 'selected' : '' }}>
                                            Inativo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="flex align-center bg-white rounded p-2 gap-2 m-auto">
                                <p>Setor: </p>
                                <div>
                                    <select onchange="sendForm()"
                                        class="appearance-none bg-whitetext-gray-700 focus:outline-none focus:shadow-outline"
                                        id="sector" name="sector">
                                        <option value="">Todos</option>
                                        @foreach ($sectors as $sector)
                                            <option value={{ $sector->id }}
                                                {{ request('sector') == $sector->id ? 'selected' : '' }}>
                                                {{ $sector->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="h-full overflow-y-auto rounded-lg border border-gray-200 shadow-md">
                <table class="w-full border border-gray-300 text-left rounded overflow-auto text-[12px]">
                    <thead class="bg-gradient-primary text-[#DCE7FA] sticky top-0 z-10">
                        <tr class="bg-gradient-primary text-[#DCE7FA]">
                            <th></th>
                            <th>Matrícula</th>
                            <th>Nome</th>
                            <th>Cargo</th>
                            <th>Setor</th>
                            <th>CPF</th>
                            <th>Admissão</th>
                            <th>Status</th>
                            <th> {{-- Editar --}} </th>
                            <th> {{-- Ver --}} </th>
                        </tr>
                    </thead>
                    <form id="employee-form" method="POST" action={{ route('employees.change') }}>
                        @csrf
                        <tbody class="bg-white text-black max-h-26 overflow-scroll">
                            @foreach ($employees as $employee)
                                <tr class="border-b border-gray-300 hover:bg-gray-200 cursor-pointer transition duration-100 ease-in-out"
                                    onclick="selectEmployee(this)">
                                    <td>
                                        <input type="radio" name="selected_employees" value="{{ $employee->id }}">
                                    </td>
                                    <td>{{ $employee->registration }}</td>
                                    <td>{{ $employee->name }}</td>
                                    <td>{{ $employee->companyRole->title ?? 'N/A' }}</td>
                                    <td>{{ $employee->sector->name ?? 'N/A' }}</td>
                                    <td>{{ $employee->cpf }}</td>
                                    <td>{{ $employee->hire_date }}</td>
                                    <td
                                        class="{{ $employee->status === 'Ativo' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $employee->status }}
                                    </td>
                                    <td>
                                        <a href="{{ route('employees.viewUpdate', ['id' => $employee->id]) }}">
                                            <i class="text-gray-700 hover:scale-120 cursor-pointer transition"
                                                data-lucide="pencil"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <span>
                                            <a href="{{ route('employees.profile', $employee->id) }}">
                                                <i class="text-gray-700 hover:scale-120 cursor-pointer transition"
                                                    data-lucide="eye"></i>
                                            </a>
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </form>
                </table>
            </div>
            <div class="flex gap-4 mt-4 justify-between bg">
                {{-- Botões Adicionar, Editar, Desativar/Ativar, Visualizar --}}
                <div>
                    <button type="submit" form="employee-form"
                        class="bg-gradient-errors hover:scale-105 transition cursor-pointer text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Desativar/Ativar Funcionário
                    </button>
                </div>

                <div>
                    <button onclick="toggleModal('modal')"
                        class="bg-gradient-primary hover:scale-105 transition cursor-pointer text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Adicionar Funcionário
                    </button>
                </div>
            </div>
        </div>
    </main>
</x-layout>
