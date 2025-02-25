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
        Schema::table('product_download_transactions', function (Blueprint $table) {
            $table->foreignId('permission_id')->nullable()->after('transaction_detail_id')->constrained()->cascadeOnDelete();
        });
    }
};
