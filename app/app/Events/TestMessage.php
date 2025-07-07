<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class TestMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $message;

    public function __construct($message = 'Hello from Laravel!')
    {
        $this->message = $message;
        // ★ 発火時にログ出力
        Log::info('[TestMessage] Event constructed', ['message' => $message]);
    }

    public function broadcastOn(): array
    {
        Log::info('[TestMessage] broadcastWith called', ['message' => $this->message]);

        return [
            new Channel('test_channel'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'TestMessage';
    }

    public function broadcastWith(): array
    {
        return [
            'message' => $this->message,
        ];
    }
}
