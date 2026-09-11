<x-layout>
    <div class="bg-[#799BD9] text-white flex items-center flex-1 rounded">
        <div class="m-auto text-center flex flex-col gap-20 w-150">
            <h1 class="text-7xl text-white font-extrabold">
                EPI Control
            </h1>
            <div class="text-center bg-white p-10 text-[#1E2636] rounded-xl w-full shadow-xl box-shadow-xl">
                <h2 class="mb-5 text-3xl font-bold">LOGIN</h2>
                <form class="text-left flex flex-col gap-2" action="/login" method="POST">
                    @csrf
                    <div class="flex flex-col">
                        <label class="text-1xl font-bold" for="email">Email ou Matrícula:</label>
                        <input class="bg-white border-2 inline-block p-2 input_form" type="text" name="email"
                            id="" placeholder="jose@gmail.com">
                        @error('email')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col">
                        <label class="text-1xl font-bold" for="password">Senha:</label>
                        <input class="bg-white border-2 inline-block p-2 input_form" type="password" name="password"
                            id="" placeholder="********">
                        @error('password')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    <button
                        class="bg-[#1E2636] text-white font-bold p-3 rounded transition-all hover:bg-[#799BD9]">Entrar</button>
                </form>
            </div>
        </div>
    </div>
</x-layout>
