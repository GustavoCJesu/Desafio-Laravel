<x-layouts.base title="Início" class="bg-brand-50">
    <div class="relative flex min-h-screen flex-col overflow-hidden">
        {{-- Decoração de fundo --}}
        <div class="pointer-events-none absolute -top-40 -right-40 size-144 rounded-full bg-accent-500/10 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-40 -left-40 size-120 rounded-full bg-brand-300/20 blur-3xl"></div>

        <header class="relative mx-auto flex w-full max-w-6xl items-center justify-between px-6 py-6">
            <div class="flex items-center gap-2 font-bold text-brand-800">
                <div class="bg-gradient-primary flex size-9 items-center justify-center rounded-lg text-white">
                    <i data-lucide="shield-check" class="size-5"></i>
                </div>
                Gestão SST
            </div>
            <a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="btn btn-secondary">
                {{ auth()->check() ? 'Ir para o painel' : 'Entrar' }}
            </a>
        </header>

        <main class="relative mx-auto grid w-full max-w-6xl flex-1 items-center gap-12 px-6 py-10 lg:grid-cols-2">
            <div>
                <span class="badge badge-info">Sistema de Gestão</span>

                <h1 class="mt-5 text-4xl leading-tight font-extrabold text-brand-900 sm:text-5xl">
                    Pessoas, treinamentos e EPIs
                    <span class="bg-gradient-primary bg-clip-text text-transparent">em um só lugar.</span>
                </h1>

                <p class="mt-6 max-w-lg text-lg leading-relaxed text-slate-600">
                    Uma solução simples para gerenciar funcionários, cargos, aulas, certificados
                    e equipamentos de proteção da sua empresa.
                </p>

                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('login') }}" class="btn btn-primary px-6 py-3 text-base">
                        Acessar o sistema <i data-lucide="arrow-right"></i>
                    </a>
                </div>

                <dl class="mt-12 grid max-w-md grid-cols-3 gap-6">
                    <div>
                        <dt class="text-xs text-slate-500 uppercase">Módulos</dt>
                        <dd class="text-2xl font-bold text-brand-800">7</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-slate-500 uppercase">Normas</dt>
                        <dd class="text-2xl font-bold text-brand-800">NRs</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-slate-500 uppercase">Acesso</dt>
                        <dd class="text-2xl font-bold text-brand-800">24/7</dd>
                    </div>
                </dl>
            </div>

            {{-- Ilustração com cartões de módulos --}}
            <div class="relative hidden lg:block">
                <div class="card shadow-elevated p-6">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-semibold text-slate-900">Visão geral</p>
                        <span class="badge badge-success">Online</span>
                    </div>
                    <div class="mt-5 grid grid-cols-2 gap-4">
                        @foreach ([
                            ['users', 'Funcionários', 'Cadastro e status'],
                            ['briefcase', 'Cargos', 'Permissões por função'],
                            ['hard-hat', 'EPIs', 'Controle de CA'],
                            ['graduation-cap', 'Aulas', 'Treinamentos e NRs'],
                        ] as [$icon, $label, $text])
                            <div class="rounded-xl border border-slate-100 bg-slate-50 p-4">
                                <div class="flex size-10 items-center justify-center rounded-lg bg-brand-100 text-brand-700">
                                    <i data-lucide="{{ $icon }}" class="size-5"></i>
                                </div>
                                <p class="mt-3 text-sm font-semibold text-slate-900">{{ $label }}</p>
                                <p class="text-xs text-slate-500">{{ $text }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card shadow-elevated absolute -bottom-8 -left-8 flex items-center gap-3 p-4">
                    <div class="flex size-10 items-center justify-center rounded-full bg-emerald-100 text-emerald-700">
                        <i data-lucide="award" class="size-5"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-900">Certificado emitido</p>
                        <p class="text-xs text-slate-500">NR-35 · Trabalho em altura</p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-layouts.base>
