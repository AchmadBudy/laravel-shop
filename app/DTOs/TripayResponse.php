<?php

declare(strict_types=1);

namespace App\DTOs;

/**
 * Represents a standardized response from the TripayService.
 */
final readonly class TripayResponse
{
    /**
     * @param bool $success Indicates if the operation was successful.
     * @param array<string, mixed>|null $response_body The actual response data or error details.
     * @param string|null $message An optional message providing additional context.
     */
    public function __construct(
        public bool $success,
        public ?array $response_body = null,
        public ?string $message = null,
    ) {}
}