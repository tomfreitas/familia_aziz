<?php

namespace App\Http\Controllers;

use App\Mail\UsuarioNaoContribuiu180;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Observacao;
use App\Models\Resposta;
use App\Models\Notification;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

//use App\Http\Controllers\NotificationController;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $titulo = 'Mantenedores';

        $hoje = now();
        $notificacoesAniversario = Notification::where('tipo', 'aniversário')
                                                ->where('is_viewed', false)
                                                ->get();

        $orderBy                = $request->input('orderBy', 'id');
        $sort                   = $request->input('sort', 'asc');
        $categoria              = $request->input('categoria', 0);
        $search                 = $request->input('search');
        $sem_contribuicao_45    = $request->input('sem_contribuicao_45', 0);

        $cont = false;

        // Query base
        $query = User::query();

        // Filtro por categoria
        if ($categoria != 0) {
            $query->where('categoria', $categoria);
            $cont = $query->count();
        }



        // Filtro de busca
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('celular', 'like', "%{$search}%");
            });
            $cont = $query->count();
        }

        // Lógica do filtro sem_contribuicao_45
        if ($sem_contribuicao_45 == 1) {
            // Lista quem contribuiu ou quem está cadastrado há menos de 45 dias
            $ultimo_dia = now()->subDays(45);
            $query->where(function ($q) use ($ultimo_dia) {
                $q->whereHas('contributions', function ($q) use ($ultimo_dia) {
                    $q->where('data_pgto', '>=', $ultimo_dia);
                })->orWhere(function ($q) use ($ultimo_dia) {
                    $q->whereDoesntHave('contributions')
                  ->where('data_mantenedor', '>=', $ultimo_dia);
                });
            });
            $cont = $query->count();

        } elseif ($sem_contribuicao_45 == 2) {
            $ultimo_dia = now()->subDays(45); // Data limite de 45 dias atrás

            $query->where(function ($q) use ($ultimo_dia) {
                $q->whereDoesntHave('contributions', function ($q) use ($ultimo_dia) {
                    $q->where('data_pgto', '>=', $ultimo_dia); // Sem contribuição nos últimos 45 dias
                })->where(function ($q) use ($ultimo_dia) {
                    $q->where('data_mantenedor', '<=', $ultimo_dia); // Mais de 45 dias desde a data de entrada no sistema
                })->orWhere(function ($q) use ($ultimo_dia) {
                    $q->whereHas('contributions', function ($q) use ($ultimo_dia) {
                        $q->where('data_pgto', '<', $ultimo_dia); // Última contribuição há mais de 45 dias
                    });
                });
            });
            $cont = $query->count();

        }

        $usuarios = $query->orderBy($orderBy, $sort)->paginate(13);
        $cont = $query->count();

        foreach ($usuarios as $usuario) {
            $ultimo_dia = now()->subDays(45); // 45 dias atrás
            // Data de referência é a última contribuição ou a data de mantenedor (se nunca contribuiu)
            $dataReferencia = $usuario->contributions()
                ->orderBy('data_pgto', 'desc')
                ->value('data_pgto') ?? $usuario->data_mantenedor;
            // O ícone aparece apenas se a data de referência for anterior a 45 dias atrás
            $usuario->showErrorIcon = $dataReferencia < $ultimo_dia;
        }

        $grupos = [
            '1' => 'Mantenedor',
            '2' => 'Voluntário',
            '3' => 'Wokshop',
            '4' => 'Semana Missionária',
            '5' => 'Notícias Família Aziz',
            '6' => 'Intercessores',
            '10' => 'Outros',
            '11' => 'Mantenedores inativos',
        ];

        return view('users.index', compact('usuarios', 'orderBy', 'sort', 'cont' , 'search', 'grupos', 'sem_contribuicao_45','categoria', 'notificacoesAniversario'))->with('titulo', $titulo);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $titulo = 'Criar novo usuário';
        return view('users.create')->with('titulo', $titulo);;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //$data = str_replace("/", "-", $_POST["data"]);
        if($request->data != ""){
            $formatdata = implode('-', array_reverse(explode('/', $request->data)));
        } else {
            $formatdata = null;
        }
        //$data_m = str_replace("/", "-", $_POST["data"]);
        $data_mante = implode('-', array_reverse(explode('/', $request->data_mantes)));

        // dd($formatdata, $data_mante);

        $inserted = DB::table('users')
                ->insert([
                        'nome'                   => $request->nome,
                        'email'                  => $request->email,
                        'país'                   => $request->pais,
                        'estado'                 => $request->estado,
                        'cidade'                 => $request->cidade,
                        'celular'                => $request->telefone,
                        'data_mantenedor'        => $data_mante,
                        'comunicacao_enviada'    => 0,
                        'comunicacao_enviada_em' => null,
                        'categoria'              => $request->categoria,
                        'melhor_dia'             => $request->melhor_dia_oferta,
                        'aniversário'            => $formatdata,
                        'username'               => $request->usuario,
                        'updated_at'             => now(),
                        'remember_token'         => Str::random(10),
                        'password'               => Hash::make('123456'),
                        'type_user'              => 2,
                    ]);
        if($inserted){
            return redirect()->route('users.index')->with('success', 'Usuário cadastrado');
        }
            return redirect()->back()->with('error', 'Usuário não cadastrado');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $usuario = User::with('contributions')->findOrFail($id);
        // Data limite de 180 dias atrás
        $dataLimite = now()->subDays(180);
        // Verifica se o usuário está sem contribuições há mais de 180 dias
        $semContribuicao180 = $usuario->contributions()
            ->where('data_pgto', '>=', $dataLimite)
            ->doesntExist() &&
            $usuario->data_mantenedor <= $dataLimite;

        $categoria = [
            '1' => 'Mantenedor',
            '2' => 'Voluntário',
            '3' => 'Wokshop',
            '4' => 'Semana Missionária',
            '5' => 'Notícias Família Aziz',
            '6' => 'Intercessores',
            '10' => 'Outros',
            '11' => 'Mantenedor inativo',
        ];

        $titulo = 'Dados de '. $usuario->nome;

        return view('users.show', compact('usuario', 'categoria', 'semContribuicao180'))->with('titulo', $titulo);;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
{
    $titulo = 'Edite seus dados';

    // Carregar o usuário com as relações contributions e observacoes
    $usuario = User::with(['contributions'])->findOrFail($id);
    $obs = User::with(['observacoes'])->findOrFail($id);

    // Data limite de 180 dias atrás
    $dataLimite = now()->subDays(180);

    // Verifica se o usuário está sem contribuições há mais de 180 dias
    $semContribuicao180 = $usuario->contributions()
        ->where('data_pgto', '>=', $dataLimite)
        ->doesntExist() &&
        $usuario->data_mantenedor <= $dataLimite;

    $categoria = [
        '1' => 'Mantenedor',
        '2' => 'Voluntário',
        '3' => 'Wokshop',
        '4' => 'Semana Missionária',
        '5' => 'Notícias Família Aziz',
        '6' => 'Intercessores',
        '10' => 'Outros',
        '11' => 'Mantenedor inativo',
    ];

    return view('users.edit', compact('usuario', 'obs', 'categoria', 'semContribuicao180'))->with('titulo', $titulo);
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $senha = $request->senha;
        $repsenha = $request->rep_senha;

        if($request->data_edit != ""){
            $formatdata = implode('-', array_reverse(explode('/', $request->data_edit)));
        } else {
            $formatdata = null;
        }
        //$data_m = str_replace("/", "-", $_POST["data"]);
        $data_mante = implode('-', array_reverse(explode('/', $request->data_mantes_edit)));

        //dd($formatdata, $data_mante);

        if($senha != $repsenha){
            return redirect()->back()->with('error', 'As senhas não conferem');
        } elseif ($senha) {
            $updated = DB::table('users')
                ->where('id', $id)
                ->update([
                    'nome'              => $request->nome,
                    'email'             => $request->email,
                    'país'              => $request->pais,
                    'estado'            => $request->estado,
                    'cidade'            => $request->cidade,
                    'celular'           => $request->telefone,
                    'data_mantenedor'   => $data_mante,
                    'melhor_dia'        => $request->melhor_dia_oferta,
                    'categoria'         => $request->categoria,
                    'aniversário'       => $formatdata,
                    'updated_at'        => now(),
                    'remember_token'    => Str::random(10),
                    'password'          => Hash::make($request->senha),
                ]);
        } else {
            $updated = DB::table('users')
                ->where('id', $id)
                ->update([
                    'nome'              => $request->nome,
                    'email'             => $request->email,
                    'país'              => $request->pais,
                    'estado'            => $request->estado,
                    'cidade'            => $request->cidade,
                    'celular'           => $request->telefone,
                    'data_mantenedor'   => $data_mante,
                    'melhor_dia'        => $request->melhor_dia_oferta,
                    'categoria'         => $request->categoria,
                    'aniversário'       => $formatdata,
                    'updated_at'        => now(),
                    'remember_token'    => Str::random(10),
                ]);
        }

        if($updated){
            return redirect()->back()->with('message', 'Dados atualizados');
        }
            return redirect()->back()->with('error', 'Dados não atualizados');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function isBirthday()
    {
        return $this->birthday && $this->birthday->isToday();
    }


    public function filter(Request $request)
    {
        $hoje = now();
        $notificacoesAniversario = Notification::where('tipo', 'aniversário')
                                                ->whereDate('created_at', $hoje)
                                                ->get();

        $sort = $request->input('sort', 'name_asc'); // Padrão: A-Z
        $query = User::query();

        if ($sort === 'name_asc') {
            $query->orderBy('nome', 'asc');
        } elseif ($sort === 'name_desc') {
            $query->orderBy('nome', 'desc');
        } elseif ($sort === 'created_at') {
            $query->orderBy('created_at', 'desc');
        }

        $usuarios = $query->get();

        // Retorne a view index com os usuários ordenados
        return view('users.index', compact('usuarios','notificacoesAniversario'));
    }


    public function enviarComunicacao($id)
    {
        $usuario = User::findOrFail($id);

        // Envia o e-mail
        Mail::to($usuario->email)->send(new UsuarioNaoContribuiu180($usuario));

        // Atualiza o status
        $usuario->update([
            'comunicacao_enviada' => true,
            'comunicacao_enviada_em' => now()
        ]);

        // Redireciona de volta com mensagem de sucesso
        return redirect()->back();
    }

    public function storeObservacao(Request $request, $userId)
    {

        $request->validate(['observacoes' => 'required']);

        $obs = Observacao::create([
            'user_id' => $userId,
            'observacao' => $request->observacoes,
        ]);

        if ($obs){
            return redirect()->back()->with('message', 'Observação registrada com sucesso!');
        }
            return redirect()->back()->with('error', 'Observação não registrada...');
    }



    public function storeResposta(Request $request, $observacaoId)
    {
        $request->validate(['resposta' => 'required']);

        Resposta::create([
            'observacao_id' => $observacaoId,
            'resposta' => $request->resposta,
        ]);

        return redirect()->back()->with('message', 'Resposta registrada com sucesso!');
    }



    public function deleteObservacao(Request $request, $userId){
        $usuario = User::findOrFail($userId);

        $dados = Observacao::findOrFail($usuario->id);
        dd($dados);
    }


}
