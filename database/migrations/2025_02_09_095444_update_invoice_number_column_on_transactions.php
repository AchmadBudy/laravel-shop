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
        Schema::table('transactions', function (Blueprint $table) {
            // delete unique constraint
            $table->dropUnique('transactions_invoice_number_unique');

            $table->string('invoice_number')->unique()->nullable()->change();
        });
    }
};
