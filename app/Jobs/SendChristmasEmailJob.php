<?php

namespace App\Jobs;

use App\Mail\ChristmasEmail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendChristmasEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Mail::to($this->user->email)->send(new ChristmasEmail($this->user));
            Log::info("E-mail de Natal enviado para: {$this->user->nome} ({$this->user->email})");
        } catch (\Exception $e) {
            Log::error("Erro ao enviar e-mail de Natal para {$this->user->email}: " . $e->getMessage());
            throw $e;
        }
    }
}
