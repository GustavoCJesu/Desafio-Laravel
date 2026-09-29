<x-layouts.base title="Entrar" class="bg-white">
    <main class="grid min-h-screen lg:grid-cols-2">
        {{-- Painel da marca --}}
        <section class="bg-gradient-sidebar relative hidden flex-col justify-between overflow-hidden p-12 text-white lg:flex">
            <div class="pointer-events-none absolute -top-24 -right-24 size-96 rounded-full bg-accent-500/30 blur-3xl"></div>

            <a href="{{ route('home') }}" class="relative flex items-center gap-2 font-bold">
                <div class="flex size-9 items-center justify-center rounded-lg bg-white/15 ring-1 ring-white/20">
                    <i data-lucide="shield-check" class="size-5"></i>
                </div>
                Gestão SST
            </a>

            <div class="relative">
                <h2 class="text-4xl leading-tight font-bold">
                    Sistema de Gestão de Cargos, Treinamentos e Funcionários
                </h2>
                <p class="mt-4 max-w-md text-brand-100">
                    Acompanhe EPIs, aulas e certificados da sua equipe com segurança e praticidade.
                </p>
            </div>

            <ul class="relative flex flex-col gap-3 text-sm text-brand-100">
                @foreach (['Controle de funcionários e cargos', 'Gestão de EPIs por CA', 'Aulas e certificados de NRs'] as $feature)
                    <li class="flex items-center gap-2">
                        <i data-lucide="check-circle-2" class="size-4 text-emerald-300"></i>{{ $feature }}
                    </li>
                @endforeach
            </ul>
        </section>

        {{-- Formulário --}}
        <section class="flex items-center justify-center bg-brand-50 p-6 lg:bg-white">
            <div class="w-full max-w-sm">
                <div class="bg-gradient-primary mb-8 flex size-12 items-center justify-center rounded-xl text-white shadow-lg lg:hidden">
                    <i data-lucide="shield-check" class="size-6"></i>
                </div>

                <h1 class="text-2xl font-bold text-slate-900">Bem-vindo de volta</h1>
                <p class="mt-1 text-sm text-slate-500">Entre com seu e-mail ou matrícula para continuar.</p>

                <form method="POST" action="{{ route('login') }}" class="mt-8 flex flex-col gap-5">
                    @csrf
                    <div>
                        <label for="email" class="form-label">E-mail ou matrícula</label>
                        <div class="relative">
                            <i data-lucide="user" class="pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2 text-slate-400"></i>
                            <input type="text" id="email" name="email" value="{{ old('email') }}" autofocus required
                                placeholder="voce@empresa.com ou 0000-0" class="form-input pl-9">
                        </div>
                    </div>
                    <div>
                        <label for="password" class="form-label">Senha</label>
                        <div class="relative">
                            <i data-lucide="lock" class="pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2 text-slate-400"></i>
                            <input type="password" id="password" name="password" required placeholder="••••••••"
                                class="form-input pl-9">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-full py-2.5">
                        Entrar <i data-lucide="log-in"></i>
                    </button>
                </form>

                <p class="mt-8 text-center text-xs text-slate-400">
                    Problemas para acessar? Fale com o administrador do sistema.
                </p>
            </div>
        </section>
    </main>
</x-layouts.base>
