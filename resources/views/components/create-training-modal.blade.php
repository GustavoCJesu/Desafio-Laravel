@props(['instructors'])

<div id="trainingModal" class="z-20 absolute hidden top-0 left-0 h-screen w-screen bg-[rgb(0,0,0,0.8)] justify-center align-center">
    <div class="bg-white h-fit w-140 m-auto rounded-md overflow-hidden flex flex-col justify-center">
        <div class="bg-gradient-primary p-4 text-white">
            <h2 class="text-xl font-bold uppercase">
                Agendar aula
            </h2>
        </div>
        <form action="{{ route('training.create') }}" method="POST" id="trainingForm">
            @csrf
            <div class="p-5 flex flex-col gap-3">
                <div class="flex flex-col">
                    <label class="font-bold" for="title">Título: </label>
                    <input name="title" required placeholder="NR-06 Uso de EPI"
                        class="border border-[rgb(0,0,0,0.25)] rounded p-2" type="text" />
                </div>
                <div class="flex flex-col">
                    <label class="font-bold" for="description">Descrição: </label>
                    <textarea name="description" required
                        class="border border-[rgb(0,0,0,0.25)] rounded p-2"></textarea>
                </div>
                <div class="flex flex-col">
                    <label class="font-bold" for="instructor_id">Instrutor: </label>
                    <select name="instructor_id" required
                        class="appearance-none border border-[rgb(0,0,0,0.5)] p-2 rounded bg-white focus:outline-none focus:shadow-outline">
                        @foreach ($instructors as $instructor)
                            <option value="{{ $instructor->id }}">{{ $instructor->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div class="flex flex-col">
                        <label class="font-bold" for="scheduled">Data e hora: </label>
                        <input name="scheduled" required
                            class="border border-[rgb(0,0,0,0.25)] rounded p-2" type="datetime-local" />
                    </div>
                    <div class="flex flex-col">
                        <label class="font-bold" for="validity_dt">Validade: </label>
                        <input name="validity_dt" required
                            class="border border-[rgb(0,0,0,0.25)] rounded p-2" type="date" />
                    </div>
                    <div class="flex flex-col">
                        <label class="font-bold" for="class_amount">Qtd. de aulas: </label>
                        <input name="class_amount" required min="1"
                            class="border border-[rgb(0,0,0,0.25)] rounded p-2" type="number" />
                    </div>
                    <div class="flex flex-col">
                        <label class="font-bold" for="class_min">Carga mín. (h): </label>
                        <input name="class_min" required min="1"
                            class="border border-[rgb(0,0,0,0.25)] rounded p-2" type="number" />
                    </div>
                </div>
                <div class="flex justify-between mt-4">
                    <button form="trainingForm" type="submit"
                        class="bg-gradient-primary text-white px-4 py-2 rounded hover:scale-110 transition">
                        Agendar
                    </button>
                    <span onclick="toggleModal('trainingModal')"
                        class="bg-gradient-errors text-white px-4 py-2 rounded hover:scale-110 transition cursor-pointer">
                        Cancelar
                    </span>
                </div>
            </div>
        </form>
    </div>
</div>
