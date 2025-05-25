<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('total_price');
            $table->integer('total_discount');
            $table->integer('total_payment');
            $table->string('email');
            $table->foreignId('payment_method_id')->constrained('payment_methods');
            $table->foreignId('payment_method_detail_id')->constrained('payment_method_details');
            $table->string('payment_status');
            $table->string('payment_url')->nullable();
            $table->string('payment_code')->nullable();
            $table->dateTime('payment_expired_at')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->timestamps();
        });
    }
};
