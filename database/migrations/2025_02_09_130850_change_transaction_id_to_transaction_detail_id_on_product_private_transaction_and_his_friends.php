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
            // drop foreign key
            $table->dropForeign(['transaction_id']);
            // drop column
            $table->dropColumn('transaction_id');
            // add foreign key
            $table->foreignId('transaction_detail_id')->constrained()->cascadeOnDelete();
        });

        Schema::table('product_shared_transactions', function (Blueprint $table) {
            // drop foreign key
            $table->dropForeign(['transaction_id']);
            // drop column
            $table->dropColumn('transaction_id');
            // add foreign key
            $table->foreignId('transaction_detail_id')->constrained()->cascadeOnDelete();
        });

        Schema::table('product_private_transactions', function (Blueprint $table) {
            // drop foreign key
            $table->dropForeign(['transaction_id']);
            // drop column
            $table->dropColumn('transaction_id');
            // add foreign key
            $table->foreignId('transaction_detail_id')->constrained()->cascadeOnDelete();
        });
    }
};
