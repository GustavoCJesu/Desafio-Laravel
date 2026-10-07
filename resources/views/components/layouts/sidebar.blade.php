@php
    $user = auth()->user();
    $userName = $user->employee->name ?? 'Usuário';

    $sections = [
        'Geral' => [
            ['route' => 'dashboard', 'match' => 'dashboard', 'icon' => 'layout-dashboard', 'label' => 'Painel'],
            ['route' => 'report.index', 'match' => 'report.*', 'icon' => 'bar-chart-3', 'label' => 'Relatórios', 'can' => 'reports.view'],
        ],
        'Pessoas' => [
            ['route' => 'employees.index', 'match' => 'employees.*', 'icon' => 'users', 'label' => 'Funcionários', 'can' => 'employees.view'],
            ['route' => 'position.index', 'match' => 'position.*', 'icon' => 'briefcase', 'label' => 'Cargos'],
        ],
        'Segurança' => [
            ['route' => 'epi.index', 'match' => 'epi.*', 'icon' => 'hard-hat', 'label' => 'EPIs', 'can' => 'epis.view'],
            ['route' => 'training.index', 'match' => 'training.*', 'icon' => 'graduation-cap', 'label' => 'Aulas', 'can' => 'trainings.view'],
            ['route' => 'certificate.index', 'match' => 'certificate.*', 'icon' => 'award', 'label' => 'Certificados'],
        ],
    ];

    $sections = collect($sections)
        ->map(fn (array $links) => array_filter($links, fn (array $link) => ! isset($link['can']) || $user->can($link['can'])))
        ->filter();
@endphp

<aside id="sidebar"
    class="bg-gradient-sidebar fixed inset-y-0 left-0 z-40 hidden w-64 shrink-0 flex-col text-white shadow-xl lg:static lg:flex lg:shadow-none">
    {{-- Marca --}}
    <div class="flex items-center gap-3 px-6 py-6">
        <div class="flex size-9 items-center justify-center rounded-lg bg-white/15 ring-1 ring-white/20">
            <i data-lucide="shield-check" class="size-5"></i>
        </div>
        <div class="leading-tight">
            <p class="text-sm font-bold">Gestão SST</p>
            <p class="text-xs text-brand-200">Pessoas & Segurança</p>
        </div>
    </div>

    {{-- Navegação --}}
    <nav class="flex-1 overflow-y-auto px-4">
        @foreach ($sections as $sectionTitle => $links)
            <p class="mt-4 mb-2 px-3 text-[11px] font-semibold tracking-wider text-brand-300 uppercase">{{ $sectionTitle }}</p>
            <ul class="flex flex-col gap-1">
                @foreach ($links as $link)
                    <li>
                        <a href="{{ route($link['route']) }}"
                            class="nav-link {{ request()->routeIs($link['match']) ? 'is-active' : '' }}">
                            <i data-lucide="{{ $link['icon'] }}"></i>{{ $link['label'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endforeach
    </nav>

    {{-- Usuário logado --}}
    <div class="m-4 flex items-center gap-3 rounded-xl bg-white/10 p-3 ring-1 ring-white/10">
        <x-ui.avatar :name="$userName" class="size-10 bg-white text-sm" />
        <div class="min-w-0 flex-1 leading-tight">
            <p class="truncate text-sm font-semibold">{{ $userName }}</p>
            <p class="truncate text-xs text-brand-200 uppercase">{{ $user->userRole->title ?? '' }}</p>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" title="Sair"
                class="flex size-8 cursor-pointer items-center justify-center rounded-lg text-brand-100 transition hover:bg-red-500 hover:text-white">
                <i data-lucide="log-out" class="size-4"></i>
            </button>
        </form>
    </div>
</aside>
