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
            // delete permission_id foreign key from product_download_transactions
            $table->dropForeign(['permission_id']);
            $table->dropColumn('permission_id');

            // add permission_id column to transaction_details
            $table->string('permission_id')->nullable()->after('product_download_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
