<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Payment;
use App\Models\Notification;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function checkout(Appointment $appointment)
    {
        $user = auth()->user();
        abort_if($appointment->student_id !== $user->id, 403);
        abort_if($appointment->estado === 'cancelada', 400, 'Cita cancelada');

        $existing = $appointment->payment()->where('status', 'paid')->first();
        if ($existing) {
            return back()->with('info', 'Esta cita ya fue pagada.');
        }

        $amount = $appointment->tutor?->tutorProfile?->tarifa_por_hora;
        if (!$amount || $amount <= 0) {
            return back()->with('error', 'El tutor no ha definido una tarifa.');
        }

        $amountCents = (int) round($amount * 100);

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'mxn',
                    'product_data' => [
                        'name' => 'Tutoría: ' . ($appointment->subject?->nombre ?? 'General'),
                        'description' => "Con {$appointment->tutor->name} - {$appointment->fecha->format('d/m/Y')} {$appointment->hora_inicio}",
                    ],
                    'unit_amount' => $amountCents,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payments.success', $appointment) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payments.cancel', $appointment),
            'customer_email' => $user->email,
            'metadata' => [
                'appointment_id' => $appointment->id,
                'student_id' => $user->id,
                'tutor_id' => $appointment->tutor_id,
            ],
        ]);

        $payment = $appointment->payment()->create([
            'student_id' => $user->id,
            'tutor_id' => $appointment->tutor_id,
            'amount' => $amountCents,
            'currency' => 'mxn',
            'stripe_session_id' => $session->id,
            'status' => 'pending',
        ]);

        return redirect($session->url);
    }

    public function success(Appointment $appointment, Request $request)
    {
        $payment = $appointment->payment()->where('stripe_session_id', $request->session_id)->first();

        if ($payment && $payment->status === 'pending') {
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

            try {
                $session = \Stripe\Checkout\Session::retrieve($request->session_id);
                if ($session->payment_status === 'paid') {
                    $payment->update([
                        'status' => 'paid',
                        'paid_at' => now(),
                    ]);

                    Notification::create([
                        'user_id' => $appointment->tutor_id,
                        'type' => 'payment',
                        'title' => 'Pago recibido',
                        'message' => "Pago de $" . $payment->formatted_amount . " MXN recibido para tu tutoría con {$appointment->student->name}.",
                        'related_id' => $appointment->id,
                        'related_type' => Appointment::class,
                    ]);
                }
            } catch (\Exception $e) {
                // log error
            }
        }

        return redirect()->route('estudiante.citas')->with('success', 'Pago realizado exitosamente.');
    }

    public function cancel(Appointment $appointment)
    {
        return redirect()->route('estudiante.citas')->with('info', 'Pago cancelado. Puedes intentar de nuevo.');
    }

    public function webhook(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (\UnexpectedValueException $e) {
            return response('Invalid payload', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response('Invalid signature', 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            $payment = Payment::where('stripe_session_id', $session->id)->first();

            if ($payment && $payment->status === 'pending') {
                $payment->update([
                    'status' => 'paid',
                    'paid_at' => now(),
                ]);

                Notification::create([
                    'user_id' => $payment->tutor_id,
                    'type' => 'payment',
                    'title' => 'Pago recibido',
                    'message' => "Pago de $" . $payment->formatted_amount . " MXN recibido.",
                    'related_id' => $payment->appointment_id,
                    'related_type' => Appointment::class,
                ]);
            }
        }

        return response('OK', 200);
    }
}
