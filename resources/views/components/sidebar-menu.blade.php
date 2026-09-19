<div class="flex flex-col min-w-74 bg-gradient-primary text-white px-6 py-10 gap-4 justify-between items-center">
    <div class="text-center">
        <div class="w-40 h-40 mx-auto rounded-full bg-[#DCE7FA] flex items-center justify-center">
            <i class="w-1/2 h-auto text-[#334A70]" data-lucide="users"></i>
        </div>
        <h1 class="text-1xl font-bold mt-4">{{ auth()->user()->employee->name }}</h1>
        <p class="uppercase">
            {{ auth()->user()->userRole->title }}
        </p>
    </div>
    <div class="text-center">
        <ul class="flex flex-col gap-1">
            <li><a class="flex items-center gap-2 p-2 rounded {{ request()->routeIs('employees.index') ? 'bg-[#1E3A5F]' : 'hover:bg-[#1E3A5F]'}}"
                    href="{{ route('employees.index') }}"><i data-lucide="users"></i>Funcionários</a></li>
            <li><a class="flex items-center gap-2 hover:bg-[#1E3A5F] p-2 rounded" href="{{ route('home') }}"><i
                        data-lucide="home"></i>Home</a></li>
            <li><a class="flex items-center gap-2 hover:bg-[#1E3A5F] p-2 rounded" href="#"><i
                        data-lucide="briefcase"></i>Cargos</a></li>
            <li><a class="flex items-center gap-2 hover:bg-[#1E3A5F] p-2 rounded" href="#"><i
                        data-lucide="hard-hat"></i>EPIs</a></li>
            <li><a class="flex items-center gap-2 hover:bg-[#1E3A5F] p-2 rounded" href="#"><i
                        data-lucide="bar-chart-2"></i>Relatórios</a></li>

        </ul>
    </div>
    <div>
        {{-- Botão de logout --}}
        <a href={{ route('logout') }}
            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Logout
        </a>
    </div>
</div>
