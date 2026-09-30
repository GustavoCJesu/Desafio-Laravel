@php
    $activeEpis = $epis->where('status', 'Ativo')->count();
@endphp

<x-layouts.app title="EPIs" subtitle="Equipamentos de proteção individual cadastrados" icon="hard-hat">
    <x-slot:modals>
        <x-modals.epi-create :categories="$categories" />
        <x-modals.epi-edit :categories="$categories" />
    </x-slot:modals>

    <x-slot:actions>
        <button type="button" onclick="toggleModal('epimodal')" class="btn btn-primary">
            <i data-lucide="plus"></i><span class="hidden sm:inline">Adicionar EPI</span>
        </button>
    </x-slot:actions>

    <div class="flex flex-col gap-6">
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <x-ui.stat-card label="EPIs cadastrados" :value="$epis->count()" icon="hard-hat" />
            <x-ui.stat-card label="Ativos" :value="$activeEpis" icon="shield-check" tone="success" />
            <x-ui.stat-card label="Inativos" :value="$epis->count() - $activeEpis" icon="shield-off" tone="danger" />
            <x-ui.stat-card label="Categorias" :value="$categories->count()" icon="layers" tone="accent" />
        </div>

        <div class="card overflow-hidden">
            <div class="card-header">
                <h2 class="card-title">Lista de EPIs</h2>
                <span class="text-xs text-slate-500">{{ $epis->count() }} registros</span>
            </div>
            <div class="max-h-[60vh] overflow-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>CA</th>
                            <th>Nome</th>
                            <th>Categoria</th>
                            <th>Status</th>
                            <th class="text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($epis as $epi)
                            <tr>
                                <td>
                                    <span
                                        class="rounded-md bg-slate-100 px-2 py-1 font-mono text-xs text-slate-700">{{ $epi->ca }}</span>
                                </td>
                                <td class="font-medium text-slate-900">{{ $epi->name }}</td>
                                <td>{{ $epi->category->name ?? 'N/A' }}</td>
                                <td>
                                    <span
                                        class="badge {{ $epi->status === 'Ativo' ? 'badge-success' : 'badge-danger' }}">
                                        {{ $epi->status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="flex items-center justify-end gap-2">
                                        <button type="button" onclick="editEpi({{ $epi->id }})" class="icon-btn"
                                            title="Editar">
                                            <i data-lucide="pencil"></i>
                                        </button>
                                        <form action="{{ route('epi.toggle', $epi->id) }}" method="POST">
                                            @csrf
                                            @if ($epi->status === 'Ativo')
                                                <button type="submit" class="btn btn-warning-soft btn-sm" title="Desativar">
                                                    <i data-lucide="power-off"></i>
                                                </button>
                                            @else
                                                <button type="submit" class="btn btn-success-soft btn-sm" title="Ativar">
                                                    <i data-lucide="power"></i>
                                                </button>
                                            @endif
                                        </form>
                                        <form action="{{ route('epi.delete', $epi->id) }}" method="POST"
                                            onsubmit="return confirm('Deseja excluir este EPI?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger-soft btn-sm" title="Excluir">
                                                <i data-lucide="trash-2"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-16 text-center">
                                    <i data-lucide="package-open" class="mx-auto size-10 text-slate-300"></i>
                                    <p class="mt-3 font-medium text-slate-700">Nenhum EPI cadastrado</p>
                                    <p class="text-sm text-slate-500">Clique em "Adicionar EPI" para começar.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        async function editEpi(id) {
            const form = document.getElementById('editEpi');
            const baseUrl = form.dataset.action;

            try {
                const response = await axios.get(`/epis/${id}`);
                const data = response.data;

                document.getElementById('edit_ca').value = data.ca;
                document.getElementById('edit_name').value = data.name;
                document.getElementById('edit_category').value = data.category_id;
                document.getElementById('edit_status').value = data.status;
                form.action = baseUrl.replace('__ID__', id);

                toggleModal('editepimodal');
            } catch (e) {
                console.log('Erro: ' + e);
            }
        }
    </script>
</x-layouts.app>
