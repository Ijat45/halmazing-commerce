<?php

namespace App\Events\Merchant;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MerchantRejected
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public User $merchant)
    {
    }
}
