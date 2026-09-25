<x-layout>
    <main class="flex-1 flex">
        <x-sidebar-menu/>  
        <div class="border  flex flex-1 m-1 items-center justify-around">
            <div class="w-fit h-fit rounded overflow-hidden border border-[rgb(0,0,0,0.25)]">
                <div class="text-xl uppercase font-bold bg-gradient-primary p-2 text-white">
                    Informações do funcionario
                </div>
                <div class="p-2 flex flex-col gap-2">
                    <div class="flex flex-col">
                        <label class="font-bold">Matricula</label>
                        <label class="border-[rgb(0,0,0,0.25)] border p-1 rounded text-gray-500"> {{ $employee->registration }} </label>
                    </div>
                    <div class="flex flex-col">
                        <label class="font-bold">Nome </label>
                        <label class="border-[rgb(0,0,0,0.25)] border p-1 rounded text-gray-500"> {{ $employee->name }} </label>
                    </div>
                    <div class="flex flex-col">
                        <label class="font-bold">CPF </label>
                        <label class="border-[rgb(0,0,0,0.25)] border p-1 rounded text-gray-500"> {{ $employee->cpf }} </label>
                    </div>
                    <div class="flex flex-col">
                        <label class="font-bold">Cargo </label>
                        <label class="border-[rgb(0,0,0,0.25)] border p-1 rounded text-gray-500"> {{ $employee->companyRole->title }} </label>
                    </div>
                    <div class="flex flex-col">
                        <label class="font-bold">Setor </label>
                        <label class="border-[rgb(0,0,0,0.25)] border p-1 rounded text-gray-500">{{ $employee->sector->name }}</label>
                    </div>
                    <div class="flex flex-col">
                        <label class="font-bold">Data de Contratação </label>
                        <label class="border-[rgb(0,0,0,0.25)] border p-1 rounded text-gray-500">{{ $employee->hire_date }}</label>
                    </div>
                    <div class="flex flex-col">
                        <label class="font-bold">Status</label>
                        <label class="border-[rgb(0,0,0,0.25)] border p-1 rounded text-gray-500">{{ $employee->status }}</label>
                    </div>
                </div>
            </div>
            <div class="w-fit h-fit rounded overflow-hidden border border-[rgb(0,0,0,0.25)]">
                <div class="text-xl uppercase font-bold bg-gradient-primary p-2 text-white">
                    Informações do usuario
                </div>
                <div class="p-2 flex flex-col gap-2">
                    <div class="flex flex-col">
                        <label class="font-bold">Email</label>
                        <label class="border-[rgb(0,0,0,0.25)] border p-1 rounded text-gray-500"> {{ $employee->user->email }} </label>
                    </div>
                    <div class="flex flex-col">
                        <label class="font-bold">Cargo do sistema </label>
                        <label class="border-[rgb(0,0,0,0.25)] border p-1 rounded text-gray-500"> {{ $employee->user->userRole->title }} </label>
                    </div>
                    <div class="flex flex-col">
                        <label class="font-bold">Status do usuario </label>
                        <label class="border-[rgb(0,0,0,0.25)] border p-1 rounded text-gray-500"> {{ $employee->user->softdel === 0 ? 'Ativo' : 'Inativo'}} </label>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>
