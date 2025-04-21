<?php

namespace App\DTOs\Notif;

class NotifChannelResponseDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public bool $success,
        public ?string $errorMessage = null
    ) {}
}
