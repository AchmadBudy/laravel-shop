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
        Schema::table('product_shared_transactions', function (Blueprint $table) {
            $table->integer('used_count')->after('transaction_detail_id')->default(1);
        });
    }
};
