<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contribution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $titulo = 'Dashboard';

        // Total de mantenedores (categoria 1)
        $totalMantenedores = User::where('categoria', 1)->count();

        // Total de mantenedores inativos (categoria 11)
        $totalInativos = User::where('categoria', 11)->count();

        // Total de pessoas cadastradas
        $totalPessoas = User::count();

        // Contribuições do mês atual
        $mesAtual = Carbon::now()->month;
        $anoAtual = Carbon::now()->year;

        $contribuicoesMes = Contribution::whereMonth('data_pgto', $mesAtual)
            ->whereYear('data_pgto', $anoAtual)
            ->sum('valor');

        $qtdContribuicoesMes = Contribution::whereMonth('data_pgto', $mesAtual)
            ->whereYear('data_pgto', $anoAtual)
            ->count();

        // Contribuições do ano atual
        $contribuicoesAno = Contribution::whereYear('data_pgto', $anoAtual)->sum('valor');

        // Mantenedores sem contribuição há mais de 45 dias
        $ultimo45dias = Carbon::now()->subDays(45);
        $semContribuicao45 = User::where('categoria', 1)
            ->where(function ($query) use ($ultimo45dias) {
                $query->where(function ($q) use ($ultimo45dias) {
                    $q->whereDoesntHave('contributions', function ($q2) use ($ultimo45dias) {
                        $q2->where('data_pgto', '>=', $ultimo45dias);
                    })->where('data_mantenedor', '<=', $ultimo45dias);
                })
                ->orWhere(function ($q) use ($ultimo45dias) {
                    $q->whereHas('contributions', function ($q2) use ($ultimo45dias) {
                        $q2->where('data_pgto', '<', $ultimo45dias);
                    });
                });
            })
            ->get()
            ->filter(function ($user) use ($ultimo45dias) {
                // Pega a última contribuição ou data de mantenedor
                $dataReferencia = $user->contributions()->orderBy('data_pgto', 'desc')->value('data_pgto') ?? $user->data_mantenedor;
                return $dataReferencia <= $ultimo45dias;
            })->count();

        // Mantenedores sem contribuição há mais de 180 dias (sem duplicar com 45 dias)
        $ultimo180dias = Carbon::now()->subDays(180);
        $semContribuicao180 = User::where('categoria', 1)
            ->where(function ($query) use ($ultimo180dias) {
                $query->where(function ($q) use ($ultimo180dias) {
                    $q->whereDoesntHave('contributions', function ($q2) use ($ultimo180dias) {
                        $q2->where('data_pgto', '>=', $ultimo180dias);
                    })->where('data_mantenedor', '<=', $ultimo180dias);
                })
                ->orWhere(function ($q) use ($ultimo180dias) {
                    $q->whereHas('contributions', function ($q2) use ($ultimo180dias) {
                        $q2->where('data_pgto', '<', $ultimo180dias);
                    });
                });
            })
            ->get()
            ->filter(function ($user) use ($ultimo180dias) {
                // Pega a última contribuição ou data de mantenedor
                $dataReferencia = $user->contributions()->orderBy('data_pgto', 'desc')->value('data_pgto') ?? $user->data_mantenedor;
                return $dataReferencia <= $ultimo180dias;
            })->count();

        // Novos mantenedores no mês (categoria 1)
        $novosMantenedoresMes = User::where('categoria', 1)
            ->whereMonth('data_mantenedor', $mesAtual)
            ->whereYear('data_mantenedor', $anoAtual)
            ->count();

        // Contribuições dos últimos 6 meses (para gráfico)
        $contribuicoesPorMes = [];
        for ($i = 5; $i >= 0; $i--) {
            $data = Carbon::now()->subMonths($i);
            $total = Contribution::whereMonth('data_pgto', $data->month)
                ->whereYear('data_pgto', $data->year)
                ->sum('valor');
            $contribuicoesPorMes[] = [
                'mes' => $data->translatedFormat('M/Y'),
                'valor' => $total
            ];
        }

        // Distribuição por estado (todos, exceto OO e vazio)
        $porEstado = User::select('estado', DB::raw('count(*) as total'))
            ->whereNotNull('estado')
            ->where('estado', '!=', '')
            ->where('estado', '!=', 'OO')
            ->groupBy('estado')
            ->orderByDesc('total')
            ->get();

        // Distribuição por categoria
        $categorias = [
            '1' => 'Mantenedor',
            '2' => 'Voluntário',
            '3' => 'Workshop',
            '4' => 'Semana Missionária',
            '5' => 'Notícias Família Aziz',
            '6' => 'Intercessores',
            '10' => 'Outros',
            '11' => 'Mantenedores inativos',
        ];

        $porCategoria = User::select('categoria', DB::raw('count(*) as total'))
            ->groupBy('categoria')
            ->get()
            ->map(function ($item) use ($categorias) {
                $item->nome = $categorias[$item->categoria] ?? 'Desconhecido';
                return $item;
            });

        // Aniversariantes do mês
        $aniversariantesMes = User::whereMonth('aniversário', $mesAtual)->count();

        // Últimas 5 contribuições
        $ultimasContribuicoes = Contribution::with('user')
            ->orderByDesc('data_pgto')
            ->limit(5)
            ->get();

        // Ticket médio
        $ticketMedio = Contribution::whereYear('data_pgto', $anoAtual)->avg('valor') ?? 0;

        return view('dashboard.index', compact(
            'titulo',
            'totalMantenedores',
            'totalInativos',
            'totalPessoas',
            'contribuicoesMes',
            'qtdContribuicoesMes',
            'contribuicoesAno',
            'semContribuicao45',
            'semContribuicao180',
            'novosMantenedoresMes',
            'contribuicoesPorMes',
            'porEstado',
            'porCategoria',
            'aniversariantesMes',
            'ultimasContribuicoes',
            'ticketMedio'
        ));
    }
}
