<?php

namespace App\Console\Commands;

use App\Mail\AppointmentReminder;
use App\Models\Appointment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendAppointmentReminders extends Command
{
    protected $signature = 'app:send-reminders';
    protected $description = 'Send email reminders for tomorrow\'s appointments';

    public function handle()
    {
        $tomorrow = now()->addDay()->toDateString();

        $appointments = Appointment::with(['student', 'tutor', 'subject'])
            ->whereDate('fecha', $tomorrow)
            ->whereIn('estado', ['pendiente', 'confirmada'])
            ->get();

        $count = 0;
        foreach ($appointments as $appointment) {
            if ($appointment->student->email) {
                Mail::to($appointment->student->email)->send(new AppointmentReminder($appointment));
                $count++;
            }
        }

        $this->info("Sent {$count} reminder(s) for tomorrow's appointments.");

        return Command::SUCCESS;
    }
}
