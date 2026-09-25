@props(['categories'])

<div id="editEpiModal" class="z-20 absolute hidden top-0 left-0 h-screen w-screen bg-[rgb(0,0,0,0.8)] justify-center align-center">
    <div class="bg-white h-fit w-140 m-auto rounded-md overflow-hidden flex flex-col justify-center">
        <div class="bg-gradient-primary p-4 text-white">
            <h2 class="text-xl font-bold uppercase">
                Editar EPI
            </h2>
        </div>
        <form method="POST" id="editEpiForm" class="p-5 flex flex-col gap-3">
            @csrf
            @method('PUT')
            <div class="flex flex-col">
                <label class="font-bold" for="edit-epi-name">Nome: </label>
                <input name="name" id="edit-epi-name" required
                    class="border border-[rgb(0,0,0,0.25)] rounded p-2" type="text" />
            </div>
            <div class="flex flex-col">
                <label class="font-bold" for="edit-epi-ca">CA: </label>
                <input name="ca" id="edit-epi-ca" required
                    class="border border-[rgb(0,0,0,0.25)] rounded p-2" type="text" />
            </div>
            <div class="flex flex-col">
                <label class="font-bold" for="edit-epi-category">Categoria: </label>
                <select name="category_id" id="edit-epi-category" required
                    class="appearance-none border border-[rgb(0,0,0,0.5)] p-2 rounded bg-white focus:outline-none focus:shadow-outline">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col">
                <label class="font-bold" for="edit-epi-status">Status: </label>
                <select name="status" id="edit-epi-status" required
                    class="appearance-none border border-[rgb(0,0,0,0.5)] p-2 rounded bg-white focus:outline-none focus:shadow-outline">
                    <option value="Ativo">Ativo</option>
                    <option value="Inativo">Inativo</option>
                </select>
            </div>
            <div class="flex justify-between mt-4">
                <button form="editEpiForm" type="submit"
                    class="bg-gradient-primary text-white px-4 py-2 rounded hover:scale-110 transition">
                    Salvar
                </button>
                <span onclick="toggleModal('editEpiModal')"
                    class="bg-gradient-errors text-white px-4 py-2 rounded hover:scale-110 transition cursor-pointer">
                    Cancelar
                </span>
            </div>
        </form>
    </div>
</div>
