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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->text('description');
            $table->bool('is_active')->default(true);
            $table->integer('price');
            $table->integer('discounted_price')->nullable();
            $table->boolean('is_warranty_available')->default(false);
            $table->text('warranty_details')->nullable();
            $table->date('warranty_end_date')->nullable();
            $table->string('product_type');
            $table->integer('quantity');
            $table->timestamps();
        });
    }
};
