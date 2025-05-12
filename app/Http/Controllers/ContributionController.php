<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contribution;
use App\Models\User;
use Illuminate\Pagination\Paginator;

class ContributionController extends Controller
{
    public function index(Request $request)
    {
        $titulo = "Contribuições";
        // Captura os filtros do request
        $formaPagamento = $request->input('forma_pagamento');
        $mes = $request->input('mes'); // Sem valor padrão
        $ano = $request->input('ano'); // Sem valor padrão

        // Base query para buscar as contribuições
        $query = Contribution::query();

        // Aplica o filtro de forma de pagamento, se selecionado
        if ($formaPagamento) {
            $query->where('forma_pgto', $formaPagamento);
        }

        // Aplica os filtros de mês e ano somente se eles forem fornecidos
        if ($mes && $ano) {
            $query->whereMonth('data_pgto', $mes)
                ->whereYear('data_pgto', $ano);
        } elseif ($ano) {
            // Apenas o ano foi selecionado
            $query->whereYear('data_pgto', $ano);
        }

        // Calcula o total contribuído somente se os filtros de mês ou ano forem aplicados
        $totalContribuido = null;
        if ($mes || $ano || $formaPagamento) {
            $totalContribuido = $query->sum('valor');
        }

        // Obtem as contribuições filtradas
        $contributions = $query->OrderBy('id', 'desc')->paginate(10);

        return view('contributions.index', compact('contributions', 'totalContribuido', 'formaPagamento', 'mes', 'ano'))->with('titulo', $titulo);
    }



    /* public function create($userId)
    {
        $user = User::findOrFail($userId);
        //dd($user); // Verifique se é um modelo individual e não uma coleção
        return view('contributions.create', compact('user'));
    } */
    public function create($userId)
    {
        $titulo = "Registrar contribuição";
        // Recupera o usuário
        $user = User::findOrFail($userId);

        // Recupera a última contribuição do usuário
        $ultimaContribuicao = $user->contributions()->orderBy('id', 'desc')->first();

        // Define valores padrão
        $dados = [
            'melhor_dia_oferta' => $ultimaContribuicao->melhor_dia_oferta ?? null,
            'forma_pgto' => $ultimaContribuicao->forma_pgto ?? null,
            'valor' => $ultimaContribuicao->valor ?? null,
        ];

        // Retorna a view com os valores
        return view('contributions.create', compact('user', 'dados'))->with('titulo', $titulo);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'melhor_dia_oferta' => 'required|integer|min:1|max:31',
            'forma_pgto' => 'required|string|max:50',
            'data_pgto' => 'required|date',
            'valor' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        ]);

        // Processar o valor
        $validated['valor'] = preg_replace('/[^\d]/', '', $validated['valor']);
        $validated['valor'] = number_format($validated['valor'] / 100, 2, '.', '');
        $tel_f = $validated['valor'];

        //dd($validated['data_pgto']);

        $usuario = User::findOrFail($validated['user_id']);
        // Salvar a contribuição
        Contribution::create([
            'user_id' => $usuario->id,
            'melhor_dia_oferta' => $request->input('melhor_dia_oferta'),
            'forma_pgto' => $request->input('forma_pgto'),
            'valor' => $tel_f,
            'data_pgto' => $validated['data_pgto'],
        ]);

        User::where('id', $validated['user_id'])
            ->update(['melhor_dia' => $validated['melhor_dia_oferta']]);


        $usuario->comunicacao_enviada = false;
        $usuario->save();

        // Redirecionar para a página do formulário com mensagem de sucesso
        return redirect()->route('contributions.create', $usuario->id)
            ->with('success', 'Contribuição registrada com sucesso!');
    }

    public function edit(string $id)
    {
        $titulo = "Editar Contribuição";

        $contribution = Contribution::findOrFail($id); // Busca a contribuição pelo ID
        return view('contributions.edit', compact('contribution'))->with('titulo', $titulo); // Retorna a view de edição

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'melhor_dia_oferta' => 'required|integer|min:1|max:31',
            'forma_pgto' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0',
            'data_pgto' => 'required|date',
        ]);

        $contribution = Contribution::findOrFail($id);
        $contribution->update($request->only(['melhor_dia_oferta', 'forma_pgto', 'data_pgto', 'valor']));

        User::where('id', $request['user_id'])
            ->update(['melhor_dia' => $request['melhor_dia_oferta']]);

        return redirect()->route('contributions.index')->with('message', 'Contribuição atualizada com sucesso!');
    }


    public function verify($userId)
    {
        $user = User::with('contributions')->findOrFail($userId); // Busca o usuário com as contribuições
        $currentMonth = now()->month;

        $hasContributed = $user->contributions->contains(function ($contribution) use ($currentMonth) {
            return $contribution->data_pgto->month == $currentMonth;
        });

        return response()->json([
            'user' => $user->nome,
            'contributed_this_month' => $hasContributed,
        ]);
    }

    public function destroy($id)
    {
        // Busca a observação e suas respostas
        $cont = Contribution::findOrFail($id);

        $cont->delete();

        return redirect()->back()->with('message', 'Contribuição excluída com sucesso.');
    }
}
