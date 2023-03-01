<?php

namespace App\Models;

use App\Events\NewMessage;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Database\Eloquent\BroadcastsEvents;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Events\ChirpCreated;

class Chirp extends Model
{
    use HasFactory, BroadcastsEvents;

    protected $fillable = [
        "message",
    ];

    protected $dispatchesEvents = [
        'created' => ChirpCreated::class
    ];

    public function user(): BelongsTo {

        return $this->belongsTo(User::class);
    }

//    public function broadcastOn(string $event): array
//    {
//        if ($event === "created") {
//            return [
//                new PresenceChannel('room'),
//            ];
//        }
//    }
}
