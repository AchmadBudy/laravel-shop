<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TripayApiController extends Controller
{
    protected $privateKey;

    public function __construct()
    {
        $this->privateKey = config('tripay.private_key');
    }

    public function handle(Request $request)
    {
        $callbackSignature = $request->server('HTTP_X_CALLBACK_SIGNATURE');
        $json = $request->getContent();
        $signature = hash_hmac('sha256', $json, $this->privateKey);

        if ($signature !== (string) $callbackSignature) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid signature',
            ]);
        }

        if ('payment_status' !== (string) $request->server('HTTP_X_CALLBACK_EVENT')) {
            return response()->json([
                'success' => false,
                'message' => 'Unrecognized callback event, no action was taken',
            ]);
        }

        $data = json_decode($json);

        if (JSON_ERROR_NONE !== json_last_error()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid data sent by tripay',
            ]);
        }

        $invoiceId = $data->merchant_ref;
        $tripayReference = $data->reference;
        $status = strtoupper((string) $data->status);


        if ($data->is_closed_payment === 1) {

            $invoice = Transaction::where('invoice_number', $invoiceId)
                ->where('payment_provider_reference', $tripayReference)
                ->where('payment_status', \App\Enums\OrderStatusEnum::Unpaid->value)
                ->first();

            if (!$invoice) {
                return response()->json([
                    'success' => false,
                    'message' => 'No invoice found or already paid: ' . $invoiceId,
                ]);
            }

            $paymentService = new \App\Services\PaymentService();

            switch ($status) {
                case 'PAID':
                    $invoice->update([
                        'payment_status' => \App\Enums\OrderStatusEnum::Paid->value,
                        'paid_at' => now(),
                    ]);

                    // send email, update stock, etc
                    $paymentService->sendItems($invoice);
                    logger($invoice);

                    break;

                case 'EXPIRED':
                    $invoice->update(['payment_status' => \App\Enums\OrderStatusEnum::Expired->value]);

                    // update stock
                    $paymentService->cancelTransaction($invoice);
                    break;

                case 'FAILED':
                    $invoice->update(['payment_status' => \App\Enums\OrderStatusEnum::Failed->value]);

                    // update stock
                    $paymentService->cancelTransaction($invoice);
                    break;

                default:
                    return response()->json([
                        'success' => false,
                        'message' => 'Unrecognized payment status',
                    ]);
            }

            return response()->json([
                'success' => true,
            ]);
        }
    }
}
