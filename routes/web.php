<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ObservacaoController;
use App\Http\Controllers\RespostaController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ContributionController;
use App\Http\Controllers\FileManagerController;
use App\Http\Controllers\EsqueciSenhaController;
use App\Http\Controllers\ResetPasswordController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailAgradecimento;
use App\Mail\ReminderEmail45;
use App\Models\User;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/test-email', function () {

    $teste_m = Mail::raw('Este é um teste.', function ($message) {
        $message->to('contato@familiaaziz.org')
                ->subject('Teste de E-mail');
    });
    if($teste_m) {
        return 'E-mails enviados!';
    }else {
        return 'Erro no E-mail enviado';
    }
});

// Login
Route::controller(LoginController::class)->group(function(){
    Route::get('/','index')->name('login.index');
    Route::post('/login','store')->name('login.store');
    Route::get('/logout','destroy')->name('login.destroy');
});

// Esqueci minha senha
/* Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/esqueci-minha-senha', [EsqueciSenhaController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/esqueci-minha-senha', [EsqueciSenhaController::class, 'sendResetLinkEmail'])->name('password.email');
}); */
// Rotas de Senha (Esqueci Minha Senha)
Route::middleware(['web'])->group(function () {
    // Rotas para exibir o formulário de redefinição de senha
    Route::get('/esqueci-minha-senha', [EsqueciSenhaController::class, 'showLinkRequestForm'])->name('password.request');
    // Rota para enviar o pedido de redefinição de senha
    Route::post('/esqueci-minha-senha', [EsqueciSenhaController::class, 'sendResetLinkEmail'])->name('password.email');
    // Rota para exibir o formulário de redefinição de senha com o token
    Route::get('/esqueci-minha-senha/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    // Rota para enviar a redefinição de senha
    Route::put('/esqueci-minha-senha/{token}', [ResetPasswordController::class, 'reset'])->name('password.update');
});

//HomeController
Route::get('/home', [HomeController::class, 'index'])->name('home');

/*  Usuarios */
//Route::resource('users', UserController::class)->middleware('auth');
Route::get('/users', [UserController::class, 'index'])->name('users.index')->middleware('auth');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create')->middleware('auth');
Route::get('/users/filter', [UserController::class, 'filter'])->name('users.filter')->middleware('auth');
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show')->middleware('auth');
Route::post('/users/store', [UserController::class, 'store'])->name('users.store')->middleware('auth');
Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('auth');
Route::put('/users/update/{user}', [UserController::class, 'update'])->name('users.update')->middleware('auth');
Route::post('users/{user}/observacoes', [UserController::class, 'storeObservacao'])->name('users.observacoes.store')->middleware('auth');
Route::post('observacoes/{observacao}/respostas', [UserController::class, 'storeResposta'])->name('observacoes.respostas.store')->middleware('auth');
// Rota para editar a observacao
Route::put('/observacoes/{id}/edit', [ObservacaoController::class, 'edit'])->name('observacoes.edit')->middleware('auth');
// Rota para excluir observações
Route::delete('/observacoes/{id}', [ObservacaoController::class, 'destroy'])->name('observacoes.destroy')->middleware('auth');
// Rota para excluir respostas
Route::get('/respostas/{id}', [RespostaController::class, 'destroy'])->name('respostas.destroy')->middleware('auth');




//Arquivos
Route::get('/file-manager/', [FileManagerController::class, 'index'])->name('file-manager.index')->middleware(['auth']);
Route::post('/file-manager/', [FileManagerController::class, 'create'])->name('file-manager.create')->middleware(['auth']);
Route::get('/file-manager/{directory?}', [FileManagerController::class, 'show'])->name('file-manager.show')->where('directory', '(.*)')->middleware(['auth']);
Route::post('/file-manager/{path?}', [FileManagerController::class, 'upload'])->name('file-manager.upload')->where('path', '(.*)')->middleware('auth');
Route::delete('/file-manager/delete_folder/{folder?}', [FileManagerController::class, 'delDir'])->name('file-manager.deldir')->where('folder', '.*')->middleware('auth');
Route::delete('/file-manager/delete/{file?}', [FileManagerController::class, 'excluirArquivo'])->name('file-manager.destroy')->where('file', '.*')->middleware('auth');
Route::put('/file-manager/{folder}', [FileManagerController::class, 'rename'])->name('file-manager.rename')->where('file', '.*')->middleware('auth');
Route::put('/file-manager/rename/{file}', [FileManagerController::class, 'renameFile'])->name('file-manager.renamefile')->where('file', '.*')->middleware('auth');
Route::get('/download/{id}', [FileManagerController::class, 'zipFile'])->name('file-manager.zipfile')->where('folder', '(.*)')->middleware('auth');
Route::get('/file-manager/busca/{busca?}', [FileManagerController::class, 'busca'])->name('file-manager.teste')->middleware(['auth']);

Route::prefix('contributions')->group(function () {
    Route::get('/', [ContributionController::class, 'index'])->name('contributions.index')->middleware(['auth']);
    Route::get('/create/{user_id?}', [ContributionController::class, 'create'])->name('contributions.create')->middleware(['auth']);
    Route::post('/store', [ContributionController::class, 'store'])->name('contributions.store')->middleware(['auth']); // Criar contribuição
    Route::get('/{id}/edit', [ContributionController::class, 'edit'])->name('contributions.edit')->middleware(['auth']);
    Route::put('/{id}', [ContributionController::class, 'update'])->name('contributions.update')->middleware(['auth']);
    Route::get('/verify/{user}', [ContributionController::class, 'verify'])->middleware(['auth']); // Verificar contribuições de um usuário
    Route::delete('/{id}', [ContributionController::class, 'destroy'])->name('contributions.destroy')->middleware(['auth']);
});

Route::prefix('notifications')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])->name('notifications.index')->middleware(['auth']);
    Route::post('/send-birthday', [NotificationController::class, 'sendBirthdayNotifications']); // Notificar aniversários
    Route::post('/send-reminders', [NotificationController::class, 'sendPaymentReminders']); // Notificar antes do vencimento
    Route::get('/notifications/{id}/mark-as-viewed', [NotificationController::class, 'markAsViewed'])->name('notifications.markAsViewed');

});

//Notificacão e-mail 180
Route::post('/usuarios/{id}/enviar-comunicacao', [UserController::class, 'enviarComunicacao'])->name('users.enviarComunicacao');


Route::get('/cron-log', function () {
    $logPath = storage_path('logs/laravel.log');

    if (!File::exists($logPath)) {
        return 'Arquivo de log não encontrado.';
    }

    // Pega as últimas 100 linhas do log
    $lines = explode("\n", File::get($logPath));
    $filtered = array_filter($lines, fn($line) => str_contains($line, 'Tarefa "minha-tarefa" executada'));

    // Pega só os últimos 10 registros (opcional)
    $lastEntries = array_slice($filtered, -10);

    return '<pre>' . implode("\n", $lastEntries) . '</pre>';
});

Route::get('/test-mail', function () {

    $usuario = User::find(7); // ou pegue o usuário que quiser

    //dd($usuario);

    Mail::to('wellington.freitas@totaltargets.com.br')->send(new ReminderEmail45($usuario));

    return 'E-mail enviado!';

});
