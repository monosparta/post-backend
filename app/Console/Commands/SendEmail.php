<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationCancelled;
use App\Models\Reservation;

class SendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:test-mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Mail';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $reservation = Reservation::first();
        Mail::to('test@example.com')->send(new ReservationCancelled($reservation));
        return 0;
    }
}
