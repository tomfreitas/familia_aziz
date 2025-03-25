<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Observacao;

class ObservacaoController extends Controller
{
    //
    public function destroy($id)
    {
        // Busca a observação e suas respostas
        $observacao = Observacao::with('respostas')->findOrFail($id);

        // Exclui as respostas associadas
        foreach ($observacao->respostas as $resposta) {
            $resposta->delete();
        }

        // Exclui a observação
        $observacao->delete();

        return redirect()->back()->with('message', 'Observação e suas respostas excluídas com sucesso.');
    }

    public function edit(Request $request, string $id)
    {
        $text = $request->edit_observacao;

        $obs = Observacao::where('id', $id)
                        ->update(['observacao' => $text]);

        if($obs){
            return redirect()->back()->with('message', 'Observação editada com sucesso.');
        }
            return redirect()->back()->with('error', 'Observação não alterada');
    }

}
