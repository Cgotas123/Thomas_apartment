<?php

namespace App\Mail;

use App\Models\Bill;
use App\Models\MeterReading;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BillNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $bill;
    public $tenant;
    public $unit;
    public $meterReadings;

    public function __construct(Bill $bill)
    {
        $this->bill = $bill;
        $this->tenant = $bill->lease->tenant;
        $this->unit = $bill->lease->unit;

        // Get meter readings for this billing period and unit
        $this->meterReadings = MeterReading::where('unit_id', $this->unit->id)
            ->whereBetween('reading_date', [
                $bill->billing_period_start,
                $bill->billing_period_end
            ])
            ->orderBy('type')
            ->orderBy('reading_date', 'desc')
            ->get();
    }

    public function build()
    {
        return $this->subject('Billing Statement - Thomas Apartment (Unit ' . $this->unit->unit_number . ')')
                    ->view('emails.bill-notification');
    }
}
