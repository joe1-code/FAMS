<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewWorkflow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $input = [];

    public $par = [];

    public $extra = [];

     /**
     * NewWorkflow constructor.
     * @param array $input
     * @param array $par
     * @param array $extra
     */
    public function __construct(array $input, array $par = [], array $extra = [])
    {

        $this->input = $input;
        $this->par = $par;
        $this->extra = $extra;
    }


    // /**
    //  * Create a new event instance.
    //  */
    // public function __construct()
    // {
    //     //
    // }

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
