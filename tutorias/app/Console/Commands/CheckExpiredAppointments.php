<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use Illuminate\Console\Command;

class CheckExpiredAppointments extends Command
{
    protected $signature = 'app:check-expired-appointments';
    protected $description = 'Marca como canceladas las citas pendientes no confirmadas';

    public function handle()
    {
        $count = Appointment::where('estado', 'pendiente')
            ->where('fecha', '<', now()->subDay()->toDateString())
            ->update([
                'estado' => 'cancelada',
                'motivo_cancelacion' => 'Automática: cita expiró sin confirmación',
                'cancelado_en' => now(),
            ]);

        $this->info("Se cancelaron {$count} citas expiradas.");
    }
}
