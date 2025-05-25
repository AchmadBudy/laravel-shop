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
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained('transactions')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products');
            $table->string('transaction_status');
            $table->boolean('is_warranty_available')->default(false);
            $table->text('warranty_details')->nullable();
            $table->date('warranty_end_date')->nullable();
            $table->string('product_type');
            $table->integer('total_price');
            $table->integer('price_each');
            $table->integer('price_each_original');
            $table->integer('quantity');
            $table->timestamps();
        });
    }
};
