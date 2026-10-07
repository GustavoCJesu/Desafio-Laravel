@php
    // Dados estáticos para prototipação da interface
    // $certificates = [
    //     ['code' => 'CERT-2026-0412', 'employee' => 'Ana Paula Souza', 'registration' => '4821-3', 'course' => 'NR-35 Trabalho em Altura', 'hours' => 8, 'issued' => '04/10/2024', 'expires' => '04/10/2026', 'status' => 'A vencer'],
    //     ['code' => 'CERT-2026-0398', 'employee' => 'Bruno Costa', 'registration' => '1932-7', 'course' => 'NR-10 Segurança em Eletricidade', 'hours' => 40, 'issued' => '11/10/2024', 'expires' => '11/10/2026', 'status' => 'A vencer'],
    //     ['code' => 'CERT-2026-0377', 'employee' => 'Juliana Martins', 'registration' => '7710-1', 'course' => 'NR-06 Uso correto de EPI', 'hours' => 4, 'issued' => '15/03/2026', 'expires' => '15/03/2027', 'status' => 'Válido'],
    //     ['code' => 'CERT-2026-0351', 'employee' => 'Marcos Oliveira', 'registration' => '3345-9', 'course' => 'NR-33 Espaço Confinado', 'hours' => 16, 'issued' => '02/02/2026', 'expires' => '02/02/2027', 'status' => 'Válido'],
    //     ['code' => 'CERT-2026-0320', 'employee' => 'Patrícia Lima', 'registration' => '0584-2', 'course' => 'NR-12 Máquinas e Equipamentos', 'hours' => 8, 'issued' => '18/09/2026', 'expires' => '18/09/2028', 'status' => 'Válido'],
    //     ['code' => 'CERT-2025-1187', 'employee' => 'Lucas Ferreira', 'registration' => '6671-5', 'course' => 'NR-23 Proteção contra Incêndios', 'hours' => 4, 'issued' => '20/08/2025', 'expires' => '20/08/2026', 'status' => 'Vencido'],
    //     ['code' => 'CERT-2025-1102', 'employee' => 'Rafael Nunes', 'registration' => '2290-4', 'course' => 'NR-11 Operação de Empilhadeira', 'hours' => 16, 'issued' => '05/06/2025', 'expires' => '05/06/2026', 'status' => 'Vencido'],
    //     ['code' => 'CERT-2026-0301', 'employee' => 'Camila Ribeiro', 'registration' => '5518-0', 'course' => 'NR-35 Trabalho em Altura', 'hours' => 8, 'issued' => '10/09/2026', 'expires' => '10/09/2028', 'status' => 'Válido'],
    // ];

    $statusBadges = ['Válido' => 'badge-success', 'A vencer' => 'badge-warning', 'Vencido' => 'badge-danger'];
    // $counts = array_count_values(array_column($certificates, 'status'));
@endphp

<x-layouts.app title="Certificados" subtitle="Certificados emitidos e controle de validade" icon="award">
    <x-slot:modals>
        <x-ui.modal id="certificateModal" title="Pré-visualização" subtitle="Certificado de conclusão" icon="award" size="max-w-3xl">
            <div class="bg-slate-100 p-4 sm:p-6">
                <div id="certificate-print" class="relative overflow-hidden rounded-lg bg-white p-8 text-center shadow-md ring-8 ring-inset ring-brand-100 sm:p-12">
                    <div class="bg-gradient-primary absolute inset-x-0 top-0 h-2"></div>
                    <div class="mx-auto flex size-14 items-center justify-center rounded-full bg-brand-100 text-brand-700">
                        <i data-lucide="award" class="size-7"></i>
                    </div>
                    <p class="mt-4 text-xs font-semibold tracking-[0.3em] text-brand-500 uppercase">Certificado de conclusão</p>
                    <p class="mt-6 text-sm text-slate-500">Certificamos que</p>
                    <p class="mt-1 text-2xl font-bold text-brand-900 sm:text-3xl" data-cert="employee"></p>
                    <p class="text-xs text-slate-500">Matrícula <span data-cert="registration"></span></p>
                    <p class="mx-auto mt-5 max-w-md text-sm text-slate-600">
                        concluiu com aproveitamento o treinamento
                        <b class="text-slate-900" data-cert="course"></b>,
                        com carga horária de <b class="text-slate-900"><span data-cert="hours"></span> horas</b>.
                    </p>
                    <div class="mt-10 grid grid-cols-2 gap-8 text-xs text-slate-500">
                        <div class="border-t border-slate-300 pt-2">
                            Emitido em <span class="font-semibold text-slate-700" data-cert="confirmed_at"></span>
                        </div>
                        <div class="border-t border-slate-300 pt-2">
                            Válido até <span class="font-semibold text-slate-700" data-cert="expires_at"></span>
                        </div>
                    </div>
                    <p class="mt-6 font-mono text-[10px] text-slate-400" data-cert="code"></p>
                </div>
            </div>
            <div class="flex justify-end gap-2 border-t border-slate-100 bg-slate-50 px-6 py-4">
                <button type="button" class="btn btn-secondary" onclick="toggleModal('certificateModal')">Fechar</button>
                <button type="button" class="btn btn-primary" onclick="printCertificate()">
                    <i data-lucide="printer"></i>Imprimir
                </button>
            </div>
        </x-ui.modal>
    </x-slot:modals>

    <x-slot:actions>
        <button type="button" class="btn btn-secondary">
            <i data-lucide="download"></i><span class="hidden sm:inline">Exportar</span>
        </button>
    </x-slot:actions>

    <div class="flex flex-col gap-6">
        <div class="grid gap-4 sm:grid-cols-3">
            <x-ui.stat-card label="Válidos" :value="$counts['Válido'] ?? 0" icon="badge-check" tone="success" />
            <x-ui.stat-card label="A vencer (60 dias)" :value="$counts['A vencer'] ?? 0" icon="alarm-clock" tone="warning" />
            <x-ui.stat-card label="Vencidos" :value="$counts['Vencido'] ?? 0" icon="badge-x" tone="danger" />
        </div>

        <div class="card overflow-hidden">
            <div class="flex flex-col gap-3 border-b border-slate-100 p-4 md:flex-row md:items-center">
                <div class="relative flex-1">
                    <i data-lucide="search" class="pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2 text-slate-400"></i>
                    <input type="search" id="certificate-search" oninput="filterCertificates()" class="form-input pl-9"
                        placeholder="Buscar por funcionário, matrícula ou curso...">
                </div>
                <select id="certificate-status" onchange="filterCertificates()" class="form-input md:w-56">
                    <option value="">Todos os status</option>
                    @foreach (array_keys($statusBadges) as $status)
                        <option>{{ $status }}</option>
                    @endforeach
                </select>
            </div>

            <div class="max-h-[60vh] overflow-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Funcionário</th>
                            <th>Treinamento</th>
                            <th>Emissão</th>
                            <th>Validade</th>
                            <th>Status</th>
                            <th class="text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody id="certificate-rows">
                        @foreach ($certificates as $certificate)
                            <tr data-status="{{ $certificate['status'] }}"
                                data-search="{{ mb_strtolower($certificate['employee'].' '.$certificate['registration'].' '.$certificate['course']) }}">
                                <td class="font-mono text-xs text-slate-500">{{ $certificate['code'] }}</td>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <x-ui.avatar :name="$certificate['employee']" class="size-9 text-xs" />
                                        <div>
                                            <p class="font-medium text-slate-900">{{ $certificate['employee'] }}</p>
                                            <p class="font-mono text-xs text-slate-500">{{ $certificate['registration'] }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $certificate['course'] }}</td>
                                <td>{{ $certificate['confirmed_at'] }}</td>
                                <td><span>{{ $certificate['expires_at'] }}</span></td>
                                <td><span class="badge {{ $statusBadges[$certificate['status']] ?? 'badge-neutral' }}">{{ $certificate['status'] }}</span></td>
                                <td>
                                    <div class="flex justify-end gap-1">
                                        <button type="button" class="icon-btn" title="Visualizar"
                                            onclick='showCertificate(@json($certificate))'>
                                            <i data-lucide="eye"></i>
                                        </button>
                                        <button type="button" class="icon-btn" title="Baixar PDF">
                                            <i data-lucide="file-down"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        <tr id="certificate-empty" class="hidden">
                            <td colspan="7" class="py-16 text-center">
                                <i data-lucide="file-search" class="mx-auto size-10 text-slate-300"></i>
                                <p class="mt-3 font-medium text-slate-700">Nenhum certificado encontrado</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function filterCertificates() {
            const search = document.getElementById('certificate-search').value.trim().toLowerCase();
            const status = document.getElementById('certificate-status').value;
            let visible = 0;

            document.querySelectorAll('#certificate-rows tr[data-status]').forEach((row) => {
                const show = (!status || row.dataset.status === status) && row.dataset.search.includes(search);
                row.classList.toggle('hidden', !show);
                visible += show ? 1 : 0;
            });

            document.getElementById('certificate-empty').classList.toggle('hidden', visible > 0);
        }

        function showCertificate(certificate) {
            document.querySelectorAll('[data-cert]').forEach((field) => {
                field.textContent = certificate[field.dataset.cert];
            });
            toggleModal('certificateModal');
        }

        function printCertificate() {
            const printWindow = window.open('', '_blank');
            const printDocument = printWindow.document;

            printDocument.title = 'Certificado';
            document.querySelectorAll('link[rel="stylesheet"], style').forEach((node) => {
                printDocument.head.appendChild(printDocument.importNode(node, true));
            });

            printDocument.body.className = 'p-8';
            printDocument.body.appendChild(printDocument.importNode(document.getElementById('certificate-print'), true));

            setTimeout(() => printWindow.print(), 300);
        }
    </script>
</x-layouts.app>
