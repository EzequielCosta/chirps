<?php

namespace App\Listeners;

use App\Events\ChirpCreated;
use App\Events\NewMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNewMessageToAll
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ChirpCreated $event): void
    {
        $userModel = $event->chirp->user;

        $data = [
            "user" => [
                "id" => $userModel->id,
                "nome" => $userModel->nome,
            ],
            ...($event->chirp->toArray())
        ];

        broadcast(
            new NewMessage($data)
        )->toOthers();
    }
}
