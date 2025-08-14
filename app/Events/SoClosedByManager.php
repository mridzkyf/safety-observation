<?php

namespace App\Events;

use App\Models\SafetyObservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SoClosedByManager extends Mailable
{
    use SerializesModels, Queueable;

    /**
     * Create a new event instance.
     */
    use Queueable, SerializesModels;

    public $so;

    public function __construct(SafetyObservation $so)
    {
        $this->so = $so;
    }

    public function build()
    {
        return $this->subject('Safety Observation Closed')
                    ->view('emails.so_closed')
                    ->with(['so' => $this->so]);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
