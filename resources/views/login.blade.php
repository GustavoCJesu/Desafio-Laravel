<x-layout>
    <main class="flex flex-col flex-1 bg-[#DCE7FA] items-center justify-center">
        <div class="m-auto w-fit p-6 bg-white rounded-lg shadow-md">
            <h1>
                <span class="text-[#334A70] font-bold text-3xl">Bem-vindo ao</span><br/>
                <span class="text-[#334A70] font-bold text-1xl">Sistema de Gestão de Cargos, Treinamentos e Funcionários</span>
            </h1>
            <div class="flex gap-8 align-center justify-center mt-6">
                <div class="m-auto">
                    <form method="POST" action="/login" class="w-74">
                        @csrf
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">
                                Email
                            </label>
                            <input type="email" id="email" name="email"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="mb-4">
                            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">
                                Password
                            </label>
                            <input type="password" id="password" name="password"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="flex items-center justify-between">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Login
                            </button>
                        </div>
                    </form>
                </div>
                <div>
                    <div class="w-64 h-64 mx-auto rounded-full bg-[#DCE7FA] flex items-center justify-center">
                        <i class="w-1/2 h-auto text-[#334A70]" data-lucide="users"></i>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>
