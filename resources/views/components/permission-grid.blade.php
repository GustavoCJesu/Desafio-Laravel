@props(['grouped', 'selected' => [], 'readonly' => false])

@php
    $groups = ['Ver' => 'eye', 'Criar' => 'circle-plus', 'Editar' => 'pencil', 'Apagar' => 'trash-2'];
@endphp

<div class="grid gap-3 sm:grid-cols-2">
    @foreach ($groups as $group => $icon)
        <div class="rounded-lg border border-slate-200 bg-slate-50/60 p-3">
            <p class="flex items-center gap-2 text-xs font-semibold tracking-wide text-slate-500 uppercase">
                <i data-lucide="{{ $icon }}" class="size-3.5"></i>{{ $group }}
            </p>
            <div class="mt-2 flex flex-col gap-1.5">
                @forelse ($grouped[$group] ?? [] as $permission)
                    <label class="flex items-center gap-2 text-sm text-slate-700 {{ $readonly ? '' : 'cursor-pointer' }}">
                        <input type="checkbox" class="form-checkbox" value="{{ $permission->id }}"
                            @if ($readonly) onclick="return false;" @else name="permission_{{ $permission->id }}" @endif
                            @checked(in_array($permission->id, $selected)) />
                        {{ $permission->name }}
                    </label>
                @empty
                    <p class="text-xs text-slate-400">Nenhuma permissão.</p>
                @endforelse
            </div>
        </div>
    @endforeach
</div>
