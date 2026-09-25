<x-layout>

    <main class="min-h-screen bg-[#DCE7FA] flex items-center justify-center p-6">

        <section
            class="w-full max-w-6xl min-h-150
                   bg-white rounded-2xl shadow-lg
                   flex items-center overflow-hidden">

            <!-- Conteúdo -->
            <div class="w-1/2 px-16">

                <span class="text-[#4A628C] font-semibold text-lg">
                    Sistema de Gestão
                </span>

                <h1 class="mt-4 text-5xl font-bold text-[#334A70]">
                    Gestão de
                    <span class="block">Funcionários</span>
                </h1>

                <p class="mt-6 max-w-lg text-lg text-gray-500 leading-relaxed">
                    Uma solução simples para gerenciar funcionários,
                    cargos, treinamentos e EPIs da sua empresa.
                </p>

                <a href="{{ route('login') }}"
                    class="inline-flex items-center gap-3
                           mt-8 px-8 py-3
                           bg-[#334A70] text-white
                           rounded-lg
                           shadow-md
                           hover:bg-[#293D5C]
                           transition">
                    Login

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4
                               M10 17l5-5-5-5
                               M15 12H3" />
                    </svg>
                </a>

            </div>


            <!-- Ilustração -->
            <div
                class="w-1/2 h-full
                       flex items-center justify-center
                       bg-[#F4F7FD]">

                <div class="text-center">

                    <div
                        class="w-64 h-64 mx-auto
                               rounded-full
                               bg-[#DCE7FA]
                               flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-32 h-32 text-[#4A628C]" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 21v-2a4 4 0 0 0-4-4H6
                                   a4 4 0 0 0-4 4v2
                                   M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8z
                                   M22 21v-2a4 4 0 0 0-3-3.87
                                   M16 3.13a4 4 0 0 1 0 7.75" />
                        </svg>
                    </div>

                    <p class="mt-6 text-[#4A628C] font-medium">
                        Gerenciamento simples e eficiente
                    </p>

                </div>

            </div>

        </section>

    </main>
</x-layout>
