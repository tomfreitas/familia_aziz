<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resposta;

class RespostaController extends Controller
{
    //
    public function destroy($id)
    {
        // Busca a resposta
        $resposta = Resposta::findOrFail($id);

        // Exclui a resposta
        $resposta->delete();

        return redirect()->back()->with('message', 'Resposta excluída com sucesso.');
    }

}
