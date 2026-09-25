<x-layout>
    <main class="flex flex-1">
        <x-sidebar-menu />
        <div class="flex flex-col max-h-screen min-h-screen flex-1 p-6 gap-4 justify-between">
            <div class="flex flex-col gap-4 flex-1 min-h-0">
                <div class="bg-gradient-primary uppercase font-bold text-2xl text-white px-6 py-4 rounded-md">
                    Certificados
                </div>

                <div class="flex-1 min-h-0 overflow-y-auto rounded-lg border border-gray-200 shadow-md">
                    <table class="w-full border border-gray-300 text-left rounded overflow-auto text-[12px]">
                        <thead class="bg-gradient-primary text-[#DCE7FA] sticky top-0 z-10">
                            <tr class="bg-gradient-primary text-[#DCE7FA]">
                                <th>Funcionário</th>
                                <th>Instrutor</th>
                                <th>Treinamento</th>
                                <th>Emitido em</th>
                                <th>Expira em</th>
                                <th>Status</th>
                                <th> {{-- Ver --}} </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white text-black">
                            @foreach ($certificates as $certificate)
                                <tr class="border-b border-gray-300 hover:bg-gray-200 transition duration-100 ease-in-out">
                                    <td>{{ $certificate->employee->name ?? 'N/A' }}</td>
                                    <td>{{ $certificate->instructor->name ?? 'N/A' }}</td>
                                    <td>{{ $certificate->sessionTraining->title ?? 'N/A' }}</td>
                                    <td>{{ $certificate->confirmed_at->format('d/m/Y') }}</td>
                                    <td>{{ $certificate->expires_at->format('d/m/Y') }}</td>
                                    <td
                                        class="{{ $certificate->status === 'Expirado' ? 'text-red-600' : 'text-green-600' }}">
                                        {{ $certificate->status }}
                                    </td>
                                    <td>
                                        <i class="text-gray-700 hover:scale-120 cursor-pointer transition"
                                            data-lucide="eye"></i>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex">
                <button type="button"
                    class="flex items-center gap-2 bg-gradient-primary p-4 text-white rounded hover:scale-105 transition cursor-pointer">
                    <i data-lucide="plus"></i>Emitir Certificado
                </button>
            </div>
        </div>
    </main>
</x-layout>
