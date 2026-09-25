@props(['training', 'epis'])

<div id="linkEpiModal" class="z-20 absolute hidden top-0 left-0 h-screen w-screen bg-[rgb(0,0,0,0.8)] justify-center align-center">
    <div class="bg-white h-fit w-140 m-auto rounded-md overflow-hidden flex flex-col justify-center">
        <div class="bg-gradient-primary p-4 text-white">
            <h2 class="text-xl font-bold uppercase">
                Vincular EPI
            </h2>
        </div>
        <form action="{{ route('attendance.epis.store', $training->id) }}" method="POST" id="linkEpiForm">
            @csrf
            <div class="p-5 flex flex-col gap-3">
                <div class="flex flex-col">
                    <label class="font-bold" for="epi_id">EPI: </label>
                    <select name="epi_id" required
                        class="appearance-none border border-[rgb(0,0,0,0.5)] p-2 rounded bg-white focus:outline-none focus:shadow-outline">
                        @foreach ($epis as $epi)
                            <option value="{{ $epi->id }}">{{ $epi->name }} (CA {{ $epi->ca }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-between mt-4">
                    <button form="linkEpiForm" type="submit"
                        class="bg-gradient-primary text-white px-4 py-2 rounded hover:scale-110 transition">
                        Vincular
                    </button>
                    <span onclick="toggleModal('linkEpiModal')"
                        class="bg-gradient-errors text-white px-4 py-2 rounded hover:scale-110 transition cursor-pointer">
                        Cancelar
                    </span>
                </div>
            </div>
        </form>
    </div>
</div>
