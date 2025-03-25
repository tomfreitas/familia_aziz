<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function index()
    {
        $titulo = "Notificações";
        $notifications = Notification::where('tipo', 'aniversário')->get();

        return view('notifications.index', compact('notifications'))->with('titulo', $titulo);
    }


    public function sendBirthdayNotifications()
    {
        $today = Carbon::today();
        $users = User::whereMonth('aniversário', $today->month)
            ->whereDay('aniversário', $today->day)
            ->get();

        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id,
                'tipo' => 'aniversário',
                'mensagem' => "Feliz aniversário, {$user->nome}!",
                'status' => 'enviada',
            ]);
        }

        return response()->json([
            'message' => 'Notificações de aniversário enviadas com sucesso!',
            'total' => count($users),
        ]);
    }

    public function sendPaymentReminders()
    {
        $users = User::all();
        $today = Carbon::today();

        foreach ($users as $user) {
            $nextPaymentDate = Carbon::createFromDate($today->year, $today->month, $user->melhor_dia_oferta);
            $daysToPayment = $today->diffInDays($nextPaymentDate, false);

            if ($daysToPayment == 5) {
                Notification::create([
                    'user_id' => $user->id,
                    'tipo' => 'vencimento',
                    'mensagem' => "Lembrete: Sua contribuição está prevista para {$nextPaymentDate->format('d/m/Y')}.",
                    'status' => 'enviada',
                ]);
            }
        }

        return response()->json([
            'message' => 'Lembretes de vencimento processados com sucesso!',
        ]);
    }


    public function markAsViewed($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->is_viewed = true;
        $notification->save();

        return redirect()->back()->with('success', 'Notificação marcada como visualizada.');
    }
}
