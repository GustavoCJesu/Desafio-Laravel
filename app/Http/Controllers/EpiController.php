<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Epi;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class EpiController extends Controller
{
    public function index(): View
    {
        $epis = Epi::with('category')->get();
        $categories = Category::all();

        return view('pages.epis.index', compact('epis', 'categories'));
    }

    public function toggle(Epi $epi)
    {

        try {
            if ($epi->status === 'Ativo') {
                $epi->update([
                    'status' => 'Inativo',
                ]);
            } else {
                $epi->update([
                    'status' => 'Ativo',
                ]);
            }

            return redirect()->back()->with('Success', 'O status foi alterado com sucesso.');
        } catch (Exception $e) {
            Log::error('Erro ao alterar o status do EPI: '.$e->getMessage());

            return redirect()->back()->with('Error', 'Nãofoi possivel alterar o status do EPI. Informações de erro no Log');
        }

    }

    public function store(Request $request)
    {
        $request->validate(['ca' => ['required', 'string', 'max:10']]);

        try {
            Epi::create([
                'name' => $request->name,
                'ca' => $request->ca,
                'category_id' => $request->category,
                'status' => $request->status,
            ]);

            return redirect(route('epi.index'))->with('Success', 'EPI criado com sucesso!');
        } catch (Exception $e) {
            Log::error('Erro ao criar o EPI: '.$e->getMessage());

            return redirect(route('epi.index'))->with('Error', 'Não foi possivel criar o EPI!'.$e->getMessage());
        }

    }

    public function show(Epi $epi): JsonResponse
    {
        return response()->json($epi);
    }

    public function update(Request $request, Epi $epi)
    {
        $request->validate(['ca' => ['required', 'string', 'max:10']]);

        try {
            $epi->update([
                'name' => $request->name,
                'ca' => $request->ca,
                'category_id' => $request->category_id,
                'status' => $request->status,
            ]);

            return redirect()->back()->with('Success', 'EPI atualizado com sucesso');
        } catch (Exception $e) {
            Log::error('Erro na atualização do EPI: '.$e->getMessage());

            return redirect()->back()->with('Error', 'Não foi possível atualizar o EPI.');
        }
    }

    public function delete(int $id)
    {
        try {
            $epi = Epi::findOrFail($id);
            $epi->delete();

            return redirect()->back()->with('Success', 'Sucesso ao deletar o EPI.');
        } catch (Exception $e) {
            Log::error('Erro ao deletar o EPI: '.$e->getMessage());

            return redirect()->back()->with('Error', 'Erro ao deletar o EPI. Informações no arquivo de log');
        }

    }
}
