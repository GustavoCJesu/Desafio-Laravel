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

        return view('epiView', compact('epis', 'categories'));
    }

    public function show(Epi $epi): JsonResponse
    {
        return response()->json($epi);
    }

    public function update(Request $request, Epi $epi)
    {
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
}
