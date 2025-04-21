<?php
declare(strict_types=1);

namespace App\DTOs\Notif;

final readonly class NotifAllResponseDTO
{
    /**
     * Create a new class instance.
     * 
     * @param bool $success
     * @param array<ChannelResponseDTO> $data
     */
    public function __construct(
        private array $data,
    )
    {}

    public function errorCount():int
    {
        return count(array_filter($this->data, fn($data) => $data->success === false));
    }

    public function isSuccess():bool
    {
        return $this->errorCount() === 0;
    }
}
