<div id="menu" class="flex flex-col h-dvh justify-between py-6 absolute bg-[#637EB0] top-0 left-0 items-center text-white z-20">
    <div class="self-end flex justify-end px-2 cursor-pointer " id="close_menu_btn">
        <x-icon.back />
    </div>
    <div class="flex flex-col justify-center items-center gap-5 px-15">
        <div class="p-4 rounded-full bg-white box-shadow-xl">
            <x-icon.user />
        </div>
        <p>Gustavo Conti Jesuino</p>
    </div>
    <div class="w-full">
        <ul class="text-center flex flex-col">
            <li class="py-4 cursor-pointer {{ request()->routeIs('site.home') ? 'active-item-menu' : 'hover:bg-[rgba(255,255,255,0.5)]'}}"><a href={{ route('site.home') }}>Relatorios</a></li>
            <li class="py-4 cursor-pointer {{ request()->routeIs('') ? 'active-item-menu' : 'hover:bg-[rgba(255,255,255,0.5)]'}}">Funcionarios</li>
            <li class="py-4 cursor-pointer {{ request()->routeIs('') ? 'active-item-menu' : 'hover:bg-[rgba(255,255,255,0.5)]'}}">Cargos</li>
            <li class="py-4 cursor-pointer {{ request()->routeIs('') ? 'active-item-menu' : 'hover:bg-[rgba(255,255,255,0.5)]'}}">EPIs</li>
            <li class="py-4 cursor-pointer {{ request()->routeIs('') ? 'active-item-menu' : 'hover:bg-[rgba(255,255,255,0.5)]'}}">Treinamentos</li>
        </ul>
    </div>
    <div>
        <form class="bg-red-600 block py-2 px-4 rounded" action="/logout" method="POST">
            @csrf
            <button>Sair</button>
        </form>
    </div>
</div>


