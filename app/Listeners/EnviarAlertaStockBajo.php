<?php

namespace App\Listeners;

use App\Events\StockBajoEvent;
use App\Models\User;
use App\Mail\StockBajoMail;
use Illuminate\Support\Facades\Mail;

class EnviarAlertaStockBajo
{
    public function handle(StockBajoEvent $event)
    {
        $admins = User::where('rol', 'administrador')->get();

        foreach ($admins as $admin) {
            Mail::to($admin->email)->queue(new StockBajoMail($event->producto));
        }
    }
}