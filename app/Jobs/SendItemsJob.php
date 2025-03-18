<?php

namespace App\Jobs;

use App\Models\Transaction;
use App\Services\PaymentService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class SendItemsJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected Transaction $transaction)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // call sendItems from PaymentService
        $result = (new PaymentService())->sendItems($this->transaction);

        // if result success is false, fail the job
        if (!$result['success']) {
            $this->fail($result['message']);
        }
    }

    /**
     * The job failed to process.
     */
    public function failed(\Throwable $exception): void
    {
        // Log the error
        Log::error('SendItemsJob failed: ' . $exception->getMessage());
    }
}
