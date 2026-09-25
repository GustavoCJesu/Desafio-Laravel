@props(['training', 'employees', 'classes'])

<div id="linkEmployeeModal" class="z-20 absolute hidden top-0 left-0 h-screen w-screen bg-[rgb(0,0,0,0.8)] justify-center align-center">
    <div class="bg-white h-fit w-140 m-auto rounded-md overflow-hidden flex flex-col justify-center">
        <div class="bg-gradient-primary p-4 text-white">
            <h2 class="text-xl font-bold uppercase">
                Vincular funcionário
            </h2>
        </div>
        <form action="{{ route('attendance.store', $training->id) }}" method="POST" id="linkEmployeeForm">
            @csrf
            <div class="p-5 flex flex-col gap-3">
                <div class="flex flex-col">
                    <label class="font-bold" for="employee_id">Funcionário: </label>
                    <select name="employee_id" required
                        class="appearance-none border border-[rgb(0,0,0,0.5)] p-2 rounded bg-white focus:outline-none focus:shadow-outline">
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col">
                    <label class="font-bold" for="classes_id">Data da aula: </label>
                    <select name="classes_id" required
                        class="appearance-none border border-[rgb(0,0,0,0.5)] p-2 rounded bg-white focus:outline-none focus:shadow-outline">
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->class_dt->format('d/m/Y') }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col">
                    <label class="font-bold" for="employee_attendence">Presença: </label>
                    <select name="employee_attendence" required
                        class="appearance-none border border-[rgb(0,0,0,0.5)] p-2 rounded bg-white focus:outline-none focus:shadow-outline">
                        <option value="Presente">Presente</option>
                        <option value="Falta">Falta</option>
                    </select>
                </div>
                <div class="flex justify-between mt-4">
                    <button form="linkEmployeeForm" type="submit"
                        class="bg-gradient-primary text-white px-4 py-2 rounded hover:scale-110 transition">
                        Vincular
                    </button>
                    <span onclick="toggleModal('linkEmployeeModal')"
                        class="bg-gradient-errors text-white px-4 py-2 rounded hover:scale-110 transition cursor-pointer">
                        Cancelar
                    </span>
                </div>
            </div>
        </form>
    </div>
</div>
